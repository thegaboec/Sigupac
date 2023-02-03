<?php

header('Content-type: application/json');
echo json_encode($locales, JSON_UNESCAPED_UNICODE);

exit();