<?php
/*
How did you implement different navigation menus or page access based on user roles (e.g., staff vs admin)? What security considerations are important?

How does a router file determine which view or controller to load based on URL parameters? What are the benefits of this approach compared to having separate PHP files for each page?

Explain how sessions are used in this application for authentication. What happens when a user logs in, and how does the application maintain their authenticated state across page requests?

How does organizing your application into folders like views, controllers, routes, and includes improve code organization? What problems does this structure solve compared to having all files in a single directory?

Trace the flow of a typical user request in this application, from when a user clicks a link or submits a form to when they see the response. Include the role of the router, security checks, controllers, and views.
*/
require_once 'routes/router.php';

