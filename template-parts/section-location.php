<section class="section-padding" id="location">
    <div class="container">
        <div class="text-center fade-in-up">
            <h2>Find Us</h2>
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">
                <?php echo nl2br( esc_html( get_field( 'address_text', 'option' ) ) ); ?>
            </p>
            
            <?php if( get_field('map_link', 'option') ): ?>
                <a href="<?php the_field('map_link', 'option'); ?>" target="_blank" class="btn btn-secondary">Get Directions</a>
            <?php endif; ?>
        </div>
    </div>
</section>

