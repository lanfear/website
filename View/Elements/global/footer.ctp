<div id="footer">
    <?php
        $cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');

        echo $this->Html->link(
            $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
            'http://www.cakephp.org/',
            array('target' => '_blank', 'escape' => false)
        );
    ?>
</div>
