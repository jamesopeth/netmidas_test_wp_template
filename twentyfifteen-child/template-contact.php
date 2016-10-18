/*
Template Name: Contact
*/
<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', 'page' );




			?>
			<article id="post-8" class="post-8 page type-page status-publish hentry">
				<?php

				echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';

	      echo '<p>';
	      echo 'Your Name (required) <br/>';
	      echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
	      echo '</p>';
	      echo '<p>';
	      echo 'Your Email (required) <br/>';
	      echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
	      echo '</p>';
	      echo '<p>';
	      echo 'Subject (required) <br/>';
	      echo '<input type="text" name="cf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" size="40" />';
	      echo '</p>';
	      echo '<p>';
	      echo 'Your Message (required) <br/>';
	      echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
	      echo '</p>';
	      echo '<p><input type="submit" name="cf-submitted" value="Send"></p>';
	      echo '</form>';

				if ( isset( $_POST['cf-submitted'] ) ) {

					// sanitize form values
					$name    = sanitize_text_field( $_POST["cf-name"] );
					$email   = sanitize_email( $_POST["cf-email"] );
					$subject = sanitize_text_field( $_POST["cf-subject"] );
					$message = esc_textarea( $_POST["cf-message"] );

					// get the blog administrator's email address
					$to = get_option( 'admin_email' );

					$headers = "From: $name <$email>" . "\r\n";

					// If email has been process for sending, display a success message
					if ( wp_mail( $to, $subject, $message, $headers ) ) {

					} else {
						echo 'Email no enviado: admin:'.$to.', subject:'.$subject;
					}

					$is_inserted = $wpdb->insert('wp_contacts', array(
					    'name' => $name,
					    'email' => $email,
					    'subject' => $subject,
							'message' => $message,
					));

					if ($is_inserted){
						echo '<div>';
						echo '<p>Los datos de contacto fueron guardados. Le contactaremos pronto.</p>';
						echo '</div>';
					}else{
						echo 'Datos de contacto no guardados!';
					}

				}


				if (is_user_logged_in()){

					global $wpdb;
					$contacts = $wpdb->get_results("SELECT * FROM wp_contacts;");

					echo "<table>";
					foreach($contacts as $contact){
					echo "<tr>";
					echo "<td>".$contact->name."</td>";
					echo "<td>".$contact->email."</td>";
					echo "<td>".$contact->subject."</td>";
					echo "<td>".$contact->message."</td>";
					echo "</tr>";
					}
					echo "</table>";
				}
				?>
			</article>
			<?php
			/**/



			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
