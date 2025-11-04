<?php
require_once __DIR__ . "/Pdo_methods.php";

/*
1. Why are we using timestamps instead of the date?

2. Is there any advantage to using the Date_time class over just having a PHP function file? What are they?

3. When a user requests to view notes within a specific date range, what logical steps must the application take to retrieve and present only the relevant notes?

4. Explain the importance of converting dates and times into a standardized format (like a timestamp) before storing them in a database. What problems might arise if you don't?

5. Imagine the application becomes very popular and has millions of notes. What performance considerations might arise when displaying notes, and how could you address them?
*/

class Date_time {
  public function addNote() {
    $output = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // make sure we have all parts of our post, if not leave them empty
      $date_time = trim($_POST['dateTime'] ?? "");
      $note_text = trim($_POST['note'] ?? "");

      // make sure both fields are filled
      if ($date_time == "" || $note_text == "") {
        $output = "You need to enter a date, time and note.";
      } else {
        // convert datetime to timestamp
        $timestamp = strtotime($date_time);

        // create database object
        $pdo = new PdoMethods();

        $sql = "INSERT INTO notes (date_time, note) VALUES (:date_time, :note)";
        $bindings = [
          [':date_time', $timestamp, 'int'],
          [':note', $note_text, 'str']
        ];

        // execute the query using bindings and such
        $result = $pdo->otherBinded($sql, $bindings);

        if ($result == 'noerror') {
          $output = "Note has been added";
        } else {
          $output = "Database error. Please try again.";
        }
      }
    }

    // render form
    $output .= <<<HTML
    <form method="post" action="index.php" class="mt-3 text-start">
      <div class="mb-3">
        <label for="dateTime" class="form-label">Date and Time</label>
        <input type="datetime-local" class="form-control" name="dateTime" id="dateTime">
      </div>

      <div class="mb-3">
        <label for="note" class="form-label">Note</label>
        <textarea class="form-control" name="note" id="note" rows="6"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
    HTML;

    return $output;
  }

  public function displayNotes() {
    // create database object
    $pdo = new PdoMethods();

    $form = <<<HTML
    <form method="post" action="display_notes.php" class="mt-3 text-start">
      <div class="mb-3">
        <label for="begDate" class="form-label">Beginning Date</label>
        <input type="date" class="form-control" name="begDate" id="begDate">
      </div>

      <div class="mb-3">
        <label for="endDate" class="form-label">Ending Date</label>
        <input type="date" class="form-control" name="endDate" id="endDate">
      </div>

      <button type="submit" class="btn btn-primary">Get Notes</button>
    </form>
    HTML;

    $results = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // make sure we have all parts of our post, if not leave them empty
      $beg_date = trim($_POST['begDate'] ?? "");
      $end_date = trim($_POST['endDate'] ?? "");

      // make sure both fields are filled
      if ($beg_date == "" || $end_date == "") {
        $results = "<p class='mt-3'>No notes found for the date range selected.</p>";
      } else {
        // convert beginning and ending dates to timestamps for comparison
        $beg_ts = strtotime($beg_date . " 00:00:00");
        $end_ts = strtotime($end_date . " 23:59:59");

        // select matching records from DB
        $sql = "SELECT date_time, note FROM notes WHERE date_time BETWEEN :begDate AND :endDate ORDER BY date_time DESC";
        $bindings = [
          [':begDate', $beg_ts, 'int'],
          [':endDate', $end_ts, 'int']
        ];

        // run query and store results
        $records = $pdo->selectBinded($sql, $bindings);

        // handle cases where no records or error
        if ($records == 'error' || count($records) == 0) {
          $results = "<p class='mt-3'>No notes found for the date range selected.</p>";
        } else {
          // add style for word wrapping in notes column
          $results = "<table class='table table-bordered mt-3'>";
          $results .= "<thead><tr><th>Date and Time</th><th>Note</th></tr></thead><tbody>";

          foreach ($records as $row) {
            // make the date string
            $date_str = date("m/d/Y h:i a", $row["date_time"]);
            $note = htmlspecialchars($row["note"]);
            $results .= "
              <tr>
                <td>{$date_str}</td>
                <td style='white-space: normal; word-wrap: break-word; max-width: 400px;'>{$note}</td>
              </tr>
            ";
          }

          $results .= "</tbody></table>";
        }
      }
    }
    return $form . $results;
  }
}
?>
