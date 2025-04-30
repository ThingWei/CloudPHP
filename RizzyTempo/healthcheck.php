<?php
// Simple health check script that always returns HTTP 200 OK.
http_response_code(200);
echo "OK";
exit();
?>
