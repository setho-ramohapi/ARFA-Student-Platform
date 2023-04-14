  <?php
//check for required fields from the form
session_start();
if (!isset($_SESSION['loggedin'])) {
header('Location: index.php');
exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'arfa';
 
 //connect to server and select database
 $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME)
     or die(mysql_error());

//verify the topic exists
 14: $verify_topic = "select topic_title from forum_topics where
 15:     topic_id = $_GET[topic_id]";
 16: $verify_topic_res = mysql_query($verify_topic, $conn)
 17:     or die(mysql_error());
 18:
 19: if (mysql_num_rows($verify_topic_res) < 1) {
 20:     //this topic does not exist
 21:    $display_block = "<P><em>You have selected an invalid topic.
 22:     Please <a href=\"topiclist.php\">try again</a>.</em></p>";
 23: } else {
 24:     //get the topic title
 25:    $topic_title = stripslashes(mysql_result($verify_topic_res,0,
 26:         'topic_title'));
 27: 
 28:    //gather the posts
 29:    $get_posts = "select post_id, post_text, date_format(post_create_time,
 30:         '%b %e %Y at %r') as fmt_post_create_time, post_owner from
 31:         forum_posts where topic_id = $_GET[topic_id]
 32:         order by post_create_time asc";
 33: 
 34:    $get_posts_res = mysql_query($get_posts,$conn) or die(mysql_error());
 35: 
 36:    //create the display string
 37:    $display_block = "
 38:    <P>Showing posts for the <strong>$topic_title</strong> topic:</p>
 39: 
 40:    <table width=100% cellpadding=3 cellspacing=1 border=1>
 41:    <tr>
 42:    <th>AUTHOR</th>
 43:    <th>POST</th>
 44:    </tr>";
 45: 
 46:    while ($posts_info = mysql_fetch_array($get_posts_res)) {
 47:        $post_id = $posts_info['post_id'];
 48:        $post_text = nl2br(stripslashes($posts_info['post_text']));
 49:        $post_create_time = $posts_info['fmt_post_create_time'];
 50:        $post_owner = stripslashes($posts_info['post_owner']);
 51: 
 52:        //add to display
 53:        $display_block .= "
 54:        <tr>
 55:        <td width=35% valign=top>$post_owner<br>[$post_create_time]</td>
 56:        <td width=65% valign=top>$post_text<br><br>
 57:         <a href=\"replytopost.php?post_id=$post_id\"><strong>REPLY TO
 58:         POST</strong></a></td>
 59:        </tr>";
 60:    }
 61: 
 62:    //close up the table
 63:    $display_block .= "</table>";
 64: }
 65: ?>
 66: <html>
 67: <head>
 68: <title>Posts in Topic</title>
 69: </head>
 70: <body>
 71: <h1>Posts in Topic</h1>
 72: <?php print $display_block; ?>
 73: </body>
 74: </html>