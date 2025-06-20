<?php 

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
  http_response_code(403);
  exit('Acesso proibido!');
}

return [
  'host' => 'mariadb_foxtrot',
  'dbname' => 'dashboarddb',
  'user' => 'shaos',
  'pass' => 'Code4Shaos!'
];
?>
