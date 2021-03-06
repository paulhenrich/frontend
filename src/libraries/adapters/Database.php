<?php
interface DatabaseInterface
{
  public function __construct($opts);
  public function deletePhoto($id);
  public function deleteAction($id);
  public function getPhoto($id);
  public function getPhotoWithActions($id);
  public function getPhotos($filter, $limit, $offset);
  // post methods update
  public function postPhoto($id, $params);
  public function postUser($id, $params);
  // put methods create but do not update
  public function putAction($id, $params);
  public function putPhoto($id, $params);
  public function putUser($id, $params);
  public function initialize();
  //private function normalizePhoto($raw);
}

function getDb(/*$type, $opts*/)
{
  static $database, $type, $opts;
  if(func_num_args() == 2)
  {
    $type = func_get_arg(0);
    $opts = func_get_arg(1);
  }
  // load configs only once
  if(!$type)
    $type = getConfig()->get('systems')->database;
  if(!$opts)
    $opts = getConfig()->get('credentials');

  if($database)
    return $database;

  switch($type)
  {
    case 'SimpleDb':
      $database = new DatabaseSimpleDb($opts);
      break;
  }
  
  if($database)
    return $database;

  throw new Exception(404, "DataProvider {$type} does not exist");
}
