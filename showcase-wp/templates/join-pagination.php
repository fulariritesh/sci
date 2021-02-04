<!-- Pagination Join -->
<ul class="nav jp-nav justify-content-center">
    <!-- Welcome -->
    <li class="nav-item <?php $w_p = is_page('welcome'); echo ($w_p) ? "act" : "";   ?>">
    <a class="nav-link" href="<?php echo get_page_link(get_page_by_path('welcome')); ?>">Get Started</a>
    </li>

    <!-- Profile Details -->
    <li class="nav-item <?php $pd_p = is_page('profile-details'); echo ($pd_p) ? "act" : "";   ?>">
    <a class="nav-link" href="<?php echo get_page_link(get_page_by_path('profile-details')); ?>">Details</a>
    </li>

    <!-- Physical Attributes -->
    <li class="nav-item <?php $pa_p = is_page('physical-attributes'); echo ($pa_p) ? "act" : "";   ?> ">
    <a class="nav-link d-none d-sm-block" href="<?php echo get_page_link(get_page_by_path('physical-attributes')); ?>"
        >Physical Attributes</a
    >
    <a class="nav-link d-block d-sm-none" href="<?php echo get_page_link(get_page_by_path('physical-attributes')); ?>">Attributes</a>
    </li>

    <!-- Add Headshot -->
    <li class="nav-item <?php $h_p = is_page('add-headshot'); echo ($h_p) ? "act" : "";  ?>">
    <a class="nav-link d-none d-sm-block" href="<?php echo get_page_link(get_page_by_path('add-headshot')); ?>"
        >Add a headshot</a
    >
    <a class="nav-link d-block d-sm-none" href="<?php echo get_page_link(get_page_by_path('add-headshot')); ?>">Headshot</a>
    </li>

    <!-- Complete -->
    <li class="nav-item <?php $w_p = is_page('complete'); echo ($w_p) ? "act" : "";   ?>">
    <a class="nav-link" href="<?php echo get_page_link(get_page_by_path('complete')); ?>">Complete</a>
    </li>
</ul>