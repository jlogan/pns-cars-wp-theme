<?php
/**
 * The template for displaying the footer
 */
?>
    </main><!-- #main -->

    <footer id="colophon" class="site-footer">
        <div class="container footer-content">
            <div class="footer-info">
                <div class="logo">PNS <span>CARS</span></div>
                <p><?php echo nl2br( esc_html( get_field( 'address_text', 'option' ) ) ); ?></p>
                <p>
                    <a href="tel:<?php the_field('contact_phone', 'option'); ?>"><?php the_field('contact_phone', 'option'); ?></a><br>
                    <a href="mailto:<?php the_field('contact_email', 'option'); ?>"><?php the_field('contact_email', 'option'); ?></a>
                </p>
            </div>
            
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#vehicles">Vehicles</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="container footer-disclaimer">
            <p>&copy; <?php echo date('Y'); ?> PNS Global Resources. All rights reserved.</p>
            <p>PNS Cars provides vehicles for drivers who use platforms such as Uber, Lyft, DoorDash, and others. We are not affiliated with or endorsed by these companies. All trademarks are the property of their respective owners.</p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>

