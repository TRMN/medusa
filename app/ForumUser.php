<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ForumUser
 *
 * @property int $user_id
 * @property bool $user_type
 * @property int $group_id
 * @property string $user_permissions
 * @property int $user_perm_from
 * @property string $user_ip
 * @property int $user_regdate
 * @property string $username
 * @property string $username_clean
 * @property string $user_password
 * @property int $user_passchg
 * @property string $user_email
 * @property int $user_email_hash
 * @property string $user_birthday
 * @property int $user_lastvisit
 * @property int $user_lastmark
 * @property int $user_lastpost_time
 * @property string $user_lastpage
 * @property string $user_last_confirm_key
 * @property int $user_last_search
 * @property bool $user_warnings
 * @property int $user_last_warning
 * @property bool $user_login_attempts
 * @property bool $user_inactive_reason
 * @property int $user_inactive_time
 * @property int $user_posts
 * @property string $user_lang
 * @property string $user_timezone
 * @property string $user_dateformat
 * @property int $user_style
 * @property int $user_rank
 * @property string $user_colour
 * @property int $user_new_privmsg
 * @property int $user_unread_privmsg
 * @property int $user_last_privmsg
 * @property bool $user_message_rules
 * @property int $user_full_folder
 * @property int $user_emailtime
 * @property int $user_topic_show_days
 * @property string $user_topic_sortby_type
 * @property string $user_topic_sortby_dir
 * @property int $user_post_show_days
 * @property string $user_post_sortby_type
 * @property string $user_post_sortby_dir
 * @property bool $user_notify
 * @property bool $user_notify_pm
 * @property bool $user_notify_type
 * @property bool $user_allow_pm
 * @property bool $user_allow_viewonline
 * @property bool $user_allow_viewemail
 * @property bool $user_allow_massemail
 * @property int $user_options
 * @property string $user_avatar
 * @property string $user_avatar_type
 * @property int $user_avatar_width
 * @property int $user_avatar_height
 * @property string $user_sig
 * @property string $user_sig_bbcode_uid
 * @property string $user_sig_bbcode_bitfield
 * @property string $user_jabber
 * @property string $user_actkey
 * @property string $user_newpasswd
 * @property string $user_form_salt
 * @property bool $user_new
 * @property bool $user_reminded
 * @property int $user_reminded_time
 * @property bool $board_announcements_status
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereBoardAnnouncementsStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserActkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAllowMassemail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAllowPm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAllowViewemail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAllowViewonline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAvatarHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAvatarType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserAvatarWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserDateformat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserEmailHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserEmailtime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserFormSalt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserFullFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserInactiveReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserInactiveTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserJabber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastConfirmKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastPrivmsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastSearch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastWarning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastpage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastpostTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLastvisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserLoginAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserMessageRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserNewPrivmsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserNewpasswd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserNotifyPm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserNotifyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPasschg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPermFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPostShowDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPostSortbyDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPostSortbyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserPosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserRegdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserReminded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserRemindedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserSig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserSigBbcodeBitfield($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserSigBbcodeUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserTopicShowDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserTopicSortbyDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserTopicSortbyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserUnreadPrivmsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUserWarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumUser whereUsernameClean($value)
 * @mixin \Eloquent
 */
class ForumUser extends Model
{
    protected $fillable = ['user_email'];

    protected $connection = 'mysql';

    protected $table = 'phpbb_users';

    protected $primaryKey = 'user_id';

    public $timestamps = false;
}
