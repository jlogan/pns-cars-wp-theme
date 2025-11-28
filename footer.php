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
                <?php
                // Get address from Customizer (with fallback to ACF)
                $address = get_theme_mod( 'pns_cars_address_text' );
                if ( empty( $address ) && function_exists( 'get_field' ) ) {
                    $address = get_field( 'address_text', 'option' );
                }
                if ( ! empty( $address ) ) {
                    echo '<p>' . nl2br( esc_html( $address ) ) . '</p>';
                }
                
                // Get phone from Customizer (with fallback to ACF)
                $phone = get_theme_mod( 'pns_cars_contact_phone' );
                if ( empty( $phone ) && function_exists( 'get_field' ) ) {
                    $phone = get_field( 'contact_phone', 'option' );
                }
                
                // Get email from Customizer (with fallback to ACF)
                $email = get_theme_mod( 'pns_cars_contact_email' );
                if ( empty( $email ) && function_exists( 'get_field' ) ) {
                    $email = get_field( 'contact_email', 'option' );
                }
                
                if ( ! empty( $phone ) || ! empty( $email ) ) {
                    echo '<p>';
                    if ( ! empty( $phone ) ) {
                        echo '<a href="tel:' . esc_attr( $phone ) . '">' . esc_html( $phone ) . '</a>';
                        if ( ! empty( $email ) ) {
                            echo '<br>';
                        }
                    }
                    if ( ! empty( $email ) ) {
                        echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
                    }
                    echo '</p>';
                }
                ?>
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
            
            <div class="site-credit">
                <a href="https://brogrammersagency.com" target="_blank" rel="noopener noreferrer" class="brogrammers-credit">
                    <span class="credit-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/brogrammers-logo.png" alt="Brogrammers Agency">
                    </span>
                    <span class="credit-text">Built by Brogrammers Agency</span>
                </a>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>

