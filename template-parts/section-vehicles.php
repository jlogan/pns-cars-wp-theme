<?php if( have_rows('vehicles_list', 'option') ): ?>
<section class="section-padding" id="vehicles">
    <div class="container">
        <div class="d-flex justify-between align-center mb-2">
            <h2 class="section-title fade-in-up">Available Vehicles</h2>
            <div class="scroll-hint text-muted fade-in-up">Swipe to see more &rarr;</div>
        </div>
        
        <div class="vehicle-slider-container fade-in-up">
            <div class="vehicle-slider">
                <?php while( have_rows('vehicles_list', 'option') ): the_row(); 
                    $img = get_sub_field('image_url');
                ?>
                    <div class="vehicle-card">
                        <div class="vehicle-image" style="background-image: url('<?php echo esc_url($img); ?>');">
                            <?php if(get_sub_field('tag')): ?>
                                <span class="vehicle-tag"><?php the_sub_field('tag'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="vehicle-content">
                            <h3><?php the_sub_field('name'); ?></h3>
                            <div class="vehicle-price"><?php the_sub_field('rate'); ?> <span>/ week</span></div>
                            <a href="#booking" class="btn btn-primary" style="width: 100%; display: block;">Book This Car</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
