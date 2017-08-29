<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLastForumLogin extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    foreach (\App\User::all() as $user) {
      try {
        $lastForumLogin = App\ForumUser::where('user_email',
          strtolower($user->email_address))
          ->firstOrFail(['user_lastvisit'])
          ->toArray();

        $user->forum_last_login = $lastForumLogin['user_lastvisit'];

      } catch (Exception $e) {

        $user->forum_last_login = FALSE;

      }

      $user->save();
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
  }
}
