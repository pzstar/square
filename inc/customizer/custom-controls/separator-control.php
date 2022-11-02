<?php

/** Separator Control */
class Hash_Themes_Separator_Control extends WP_Customize_Control {

    /**
     * Control type
     *
     * @var string
     */
    public $type = 'ht--separator';

    /**
     * Control method
     *
     * @since 1.0.0
     */
    public function render_content() {
        ?>
        <p><span></span></p>
        <?php

    }

}
