<?php
// Simple redirect to your actual callback handler
header("Location: http://localhost/HarmonyFlow/google_callback.php?" . http_build_query($_GET));
exit;
