<?php if( have_rows('faqs', 'option') ): ?>
<section class="section-padding" id="faq">
    <div class="container faq-container">
        <h2 class="section-title text-center mb-2 fade-in-up">Frequently Asked Questions</h2>
        
        <?php while( have_rows('faqs', 'option') ): the_row(); ?>
            <div class="faq-item fade-in-up">
                <div class="faq-question">
                    <?php the_sub_field('question'); ?>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p><?php the_sub_field('answer'); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>
<?php endif; ?>

