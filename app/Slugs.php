<?php namespace App;
use Illuminate\Database\Eloquent\Model;
// instance of Posts class will refer to posts table in database
class Slugs extends Model {
  //restricts columns from modifying
  protected $guarded = [];
  // posts has many comments
  // returns all comments on that post
  
}