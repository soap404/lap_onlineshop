<?php
session_start();
const DOMAIN = '/lap_onlineshop';

require_once __DIR__.'/core/Validation.php';
require_once __DIR__.'/core/Messages.php';
require_once __DIR__.'/database/DB.php';
require_once __DIR__.'/middleware/middleware.php';