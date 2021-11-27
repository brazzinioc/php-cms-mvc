<?php 
declare(strict_types=1);

namespace Interfaces;

interface CrudInterface
{
  public function save();
  public function create();
  public function update();
  public function delete();
}


?>