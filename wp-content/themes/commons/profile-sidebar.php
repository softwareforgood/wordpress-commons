<div class="widget org-info">
  <h4 class="widgettitle">Company Information</h4>
  <div class="widget-content">
    <?php if(bp_get_member_profile_data('field=Organization')) { ?>
      <div class="org-title"><?php bp_member_profile_data( 'field=Organization' ); ?></div>
    <?php } if(bp_get_member_profile_data('field=Position')) { ?>
      <div class="org-title"><?php bp_member_profile_data( 'field=Position' ); ?></div>
    <?php } if(bp_get_member_profile_data('field=Business Address')) { ?>
      <div class="address"><?php bp_member_profile_data( 'field=Business Address' ); ?></div>
    <?php } if(bp_get_member_profile_data('field=Work E-mail')) { ?>
      <div><a href="mailto:<?php bp_member_profile_data( 'field=Work E-mail' ); ?>"><?php bp_member_profile_data( 'field=Work E-mail' ); ?></a></div>
    <?php } if(bp_get_member_profile_data('field=Website')) {
        echo '<div>' . bp_get_member_profile_data('field=Website') . '</div>'; ?>
    <?php } ?>
  </div>
</div>

<div class="widget expertise">
  <h4 class="widgettitle">Areas of Expertise</h4>
  <div class="widget-content">
    <?php $data=xprofile_get_field_data( 'Expertise', bp_get_member_user_id() ); ?>
    <?php if(!empty($data)) { ?>
    <ul>
      <li>
        <?php
            if($data && is_array($data)){
              $data=join('</li><li>',$data);
            }
        echo $data; ?>
      </li>
    </ul>
    <?php } else { ?>
      <div>None added</div>
    <?php } ?>
  </div>
</div>