<?php

// Upgrade Text
class Square_Upgrade_Info_Control extends WP_Customize_Control {

    public $type = 'ht--upgrade-info';

    public function render_content() {
        if ($this->label) {
            ?>
            <label>
                <span class="dashicons dashicons-info"></span>

                <span>
                    <?php echo wp_kses_post($this->label); ?>
                </span>

                <a href="<?php echo esc_url('https://hashthemes.com/wordpress-theme/square-plus/?utm_source=wordpress&utm_medium=square-link&utm_campaign=square-upgrade'); ?>" target="_blank"> <strong><?php echo esc_html__('Upgrade to PRO', 'square'); ?></strong></a>
            </label>
        <?php } ?>

        <?php if ($this->description) { ?>
            <span class="description customize-control-description">
                <?php echo wp_kses_post($this->description); ?>
            </span>
            <?php
        }

        $choices = $this->choices;
        if ($choices) {
            echo '<ul>';
            foreach ($choices as $choice) {
                echo '<li>' . esc_html($choice) . '</li>';
            }
            echo '</ul>';
        }
    }

}
