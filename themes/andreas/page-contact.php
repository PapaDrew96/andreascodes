<?php
/**
 * Template Name: Contact Page
 */

get_header();
?>

<section class="contact-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="display-5">Let’s Work Together</h1>
      <p class="lead text-muted">Got a project in mind or just want to say hi? Fill out the form below and I’ll get back to you soon.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="contact-form-wrapper">
          <?php echo do_shortcode('[wpforms id="204" title="false"]'); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
