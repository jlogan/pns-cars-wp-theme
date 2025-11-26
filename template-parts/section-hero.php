<?php
$headline = get_field('hero_headline', 'option');
$subhead = get_field('hero_subheadline', 'option');
$cta1 = get_field('hero_cta_primary', 'option');
$cta2 = get_field('hero_cta_secondary', 'option');
?>
<section class="hero-section" id="hero">
    <div class="hero-bg-accent"></div>
    <div class="container">
        <div class="hero-content fade-in-up">
            <h1 class="hero-title"><?php echo esc_html($headline); ?></h1>
            <p class="hero-subtitle"><?php echo esc_html($subhead); ?></p>
            
            <div class="hero-buttons">
                <?php if($cta1): ?>
                    <a href="#vehicles" class="btn btn-primary"><?php echo esc_html($cta1); ?></a>
                <?php endif; ?>
                <?php if($cta2): ?>
                    <a href="#contact" class="btn btn-secondary"><?php echo esc_html($cta2); ?></a>
                <?php endif; ?>
            </div>

            <div class="hero-badges">
                <span>Perfect for:</span>
                <div><span class="badge-icon">✓</span>Uber</div>
                <div><span class="badge-icon">✓</span>Lyft</div>
                <div><span class="badge-icon">✓</span>DoorDash</div>
            </div>
        </div>
    </div>
</section>

