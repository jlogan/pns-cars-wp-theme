<?php
if( have_rows('steps', 'option') ): ?>
<section class="section-padding" id="how-it-works">
    <div class="container">
        <h2 class="section-title text-center fade-in-up"><?php echo esc_html( get_field( 'how_it_works_heading', 'option' ) ?: 'How It Works' ); ?></h2>
        <div class="steps-grid">
            <?php 
            $i = 1;
            while( have_rows('steps', 'option') ): the_row(); 
                $icon = get_sub_field('icon');
                $title = get_sub_field('title');
                $desc = get_sub_field('description');
            ?>
                <div class="step-card fade-in-up" style="transition-delay: <?php echo $i * 100; ?>ms">
                    <div class="step-number"><?php echo $i; ?></div>
                    <div class="step-icon"><?php echo esc_html($icon); ?></div>
                    <h3><?php echo esc_html($title); ?></h3>
                    <p class="text-muted"><?php echo esc_html($desc); ?></p>
                </div>
            <?php 
            $i++;
            endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

