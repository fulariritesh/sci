<!-- Pagination Join -->
<ul class="nav jp-nav justify-content-center">
    <!-- Welcome -->
    <li class="nav-item <?php $w_p = is_page($welcome_page); echo ($w_p) ? "act" : "";   ?>">
    <a class="nav-link" href="<?php echo get_page_link($welcome_page); ?>">Get Started</a>
    </li>

    <!-- Profile Details -->
    <li class="nav-item <?php $pd_p = is_page($profile_details_page); echo ($pd_p) ? "act" : "";   ?>">
    <a class="nav-link" href="<?php echo get_page_link($profile_details_page); ?>">Details</a>
    </li>

    <!-- Physical Attributes -->
    <li class="nav-item <?php $pa_p = is_page($physical_attributes_page); echo ($pa_p) ? "act" : "";   ?> ">
    <a class="nav-link d-none d-sm-block" href="<?php echo get_page_link($physical_attributes_page); ?>"
        >Physical Attributes</a
    >
    <a class="nav-link d-block d-sm-none" href="<?php echo get_page_link($physical_attributes_page); ?>">Attributes</a>
    </li>

    <!-- Add Headshot -->
    <li class="nav-item <?php $h_p = is_page($add_headshot_page); echo ($h_p) ? "act" : "";  ?>">
    <a class="nav-link d-none d-sm-block" href="<?php echo get_page_link($add_headshot_page); ?>"
        >Add a headshot</a
    >
    <a class="nav-link d-block d-sm-none" href="<?php echo get_page_link($add_headshot_page); ?>">Headshot</a>
    </li>

    <!-- Complete -->
    <li class="nav-item <?php $w_p = is_page($complete_page); echo ($w_p) ? "act" : "";   ?>">
    <a class="nav-link" href="<?php echo get_page_link($complete_page); ?>">Complete</a>
    </li>
</ul>