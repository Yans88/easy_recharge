<!-- search form -->
<a href="<?php echo site_url(); ?>" class="logo">
    <!-- Add the class icon to your logo image or logo icon to add the margining -->
    <div style="text-align:center; color:#01DF3A; font-weight:600;">Selamat Datang Dihalaman Administrator Easy
        Recharge
    </div>
</a>
<!-- /.search form -->

<ul class="sidebar-menu">
    <li class="hide <?php
    $menu_home_arr = array('home', '');
    if (in_array($this->uri->segment(1), $menu_home_arr)) {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>home">
            <img height="20" src="<?php echo base_url() . 'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
        </a>
    </li>

    <li class="<?php
    $menu_home_arr = array('merchants', '');
    if (in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) != 'list_machine') {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>merchants">
            <i class="glyphicon glyphicon-stats"></i> <span>Station</span>
        </a>
    </li>

    <li class=" <?php
    $menu_home_arr = array('preset_template', '');
    if (in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) != 'preset_template') {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>preset_template">
            <i class="glyphicon glyphicon-stats"></i> <span>Preset Template</span>
        </a>
    </li>

    <li class=" <?php
    $menu_home_arr = array('fee_vendor', '');
    if (in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) == '') {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>fee_vendor">
            <i class="glyphicon glyphicon-stats"></i> <span>Fee Vendor</span>
        </a>
    </li>

    <li class=" <?php
    $menu_home_arr = array('fee_vendor', '');
    if (in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) == 'report') {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>fee_vendor/report">
            <i class="glyphicon glyphicon-stats"></i> <span>Report Fee Vendor</span>
        </a>
    </li>

    <li class="<?php
    $menu_home_arr = array('kategori', '');
    if (in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) != 'kategori') {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>kategori">
            <i class="glyphicon glyphicon-stats"></i> <span>Kategori</span>
        </a>
    </li>

    <li class="<?php
    $menu_home_arr = array('merchants', '');
    if (in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) == 'list_machine') {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>merchants/list_machine">
            <i class="glyphicon glyphicon-stats"></i> <span>Vending Machine</span>
        </a>
    </li>

    <li class="<?php
    $menu_home_arr = array('vendors', '');
    if (in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) != 'vendors') {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>vendors">
            <i class="glyphicon glyphicon-stats"></i> <span>Vendors</span>
        </a>
    </li>

    <li class="<?php
    $menu_home_arr = array('transaksi', '');
    if (in_array($this->uri->segment(1), $menu_home_arr)) {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>transaksi">
            <i class="glyphicon glyphicon-stats"></i> <span>Transaksi</span>
        </a>
    </li>

    <li class="treeview <?php
    $menu_trans_arr = array('topup_point');
    if (in_array($this->uri->segment(1), $menu_trans_arr)) {
        echo "active";
    } ?>">

        <a href="#">
            <i class="glyphicon glyphicon-stats"></i>
            <span>Top up Point</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="<?php if ($this->uri->segment(1) == 'topup_point' && $this->uri->segment(2) == '') {
                echo 'active';
            } ?>"><a href="<?php echo base_url(); ?>topup_point"><i class="fa fa-folder-open-o"></i> Waiting Payment</a>
            </li>

            <li class="<?php if ($this->uri->segment(1) == 'topup_point' && $this->uri->segment(2) == 'complete') {
                echo 'active';
            } ?>"><a href="<?php echo base_url(); ?>topup_point/complete"><i class="fa fa-folder-open-o"></i> Payment
                    Complete </a></li>

        </ul>
    </li>

    <li class="<?php
    $menu_home_arr = array('members', '');
    if (in_array($this->uri->segment(1), $menu_home_arr)) {
        echo "active";
    } ?>">
        <a href="<?php echo base_url(); ?>members">
            <i class="glyphicon glyphicon-stats"></i> <span>Members</span>
        </a>
    </li>


    <li class="<?php if ($this->uri->segment(1) == 'banner') {
        echo 'active';
    } ?>"><a href="<?php echo base_url(); ?>banner"><i class="glyphicon glyphicon-stats"></i> Banner </a></li>

    <li class="<?php if ($this->uri->segment(1) == 'faq') {
        echo 'active';
    } ?>"><a href="<?php echo base_url(); ?>faq"><i class="glyphicon glyphicon-stats"></i> FAQ </a></li>
    <li class="hide <?php if ($this->uri->segment(1) == 'faq_merchant') {
        echo 'active';
    } ?>"><a href="<?php echo base_url(); ?>faq_merchant"><i class="glyphicon glyphicon-stats"></i> Tutorial</a></li>
    <li class="hide <?php if ($this->uri->segment(1) == 'role') {
        echo 'active';
    } ?>"><a href="<?php echo base_url(); ?>role"><i class="glyphicon glyphicon-stats"></i> Level </a></li>
    <li class="<?php if ($this->uri->segment(1) == 'user') {
        echo 'active';
    } ?>"><a href="<?php echo base_url(); ?>user"><i class="glyphicon glyphicon-stats"></i> Users </a></li>

    <li class="<?php if ($this->uri->segment(1) == 'setting') {
        echo 'active';
    } ?>"><a href="<?php echo base_url(); ?>setting"><i class="glyphicon glyphicon-stats"></i> Setting </a></li>

</ul>