<style>
    #custom-search-input {
        background: #e8e6e7 none repeat scroll 0 0;
        margin: 0;
        padding: 10px;
    }

    #custom-search-input .search-query {
        background: #fff none repeat scroll 0 0 !important;
        border-radius: 4px;
        height: 33px;
        margin-bottom: 0;
        padding-left: 7px;
        padding-right: 7px;
    }

    #custom-search-input button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: 0 none;
        border-radius: 3px;
        color: #666666;
        left: auto;
        margin-bottom: 0;
        margin-top: 7px;
        padding: 2px 5px;
        position: absolute;
        right: 0;
        z-index: 9999;
    }

    .search-query:focus+button {
        z-index: 3;
    }

    .all_conversation button {
        background: #f5f3f3 none repeat scroll 0 0;
        border: 1px solid #dddddd;
        height: 38px;
        text-align: left;
        width: 100%;
    }

    .all_conversation i {
        background: #e9e7e8 none repeat scroll 0 0;
        border-radius: 100px;
        color: #636363;
        font-size: 17px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        width: 30px;
    }

    .all_conversation .caret {
        bottom: 0;
        margin: auto;
        position: absolute;
        right: 15px;
        top: 0;
    }

    .all_conversation .dropdown-menu {
        background: #f5f3f3 none repeat scroll 0 0;
        border-radius: 0;
        margin-top: 0;
        padding: 0;
        width: 100%;
    }

    .all_conversation ul li {
        border-bottom: 1px solid #dddddd;
        line-height: normal;
        width: 100%;
    }

    .all_conversation ul li a:hover {
        background: #dddddd none repeat scroll 0 0;
        color: #333;
    }

    .all_conversation ul li a {
        color: #333;
        line-height: 30px;
        padding: 3px 20px;
    }

    .member_list .chat-body {
        margin-left: 47px;
        margin-top: 0;
    }

    .top_nav {
        overflow: visible;
    }

    .member_list .contact_sec {
        margin-top: 3px;
    }

    .member_list li {
        padding: 6px;
    }

    .member_list ul {
        border: 1px solid #dddddd;
    }

    .chat-img img {
        height: 34px;
        width: 34px;
    }

    .member_list li {
        border-bottom: 1px solid #dddddd;
        padding: 6px;
    }

    .member_list li:last-child {
        border-bottom: none;
    }

    .member_list {
        height: 380px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .sub_menu_ {
        background: #e8e6e7 none repeat scroll 0 0;
        left: 100%;
        max-width: 233px;
        position: absolute;
        width: 100%;
    }

    .sub_menu_ {
        background: #f5f3f3 none repeat scroll 0 0;
        border: 1px solid rgba(0, 0, 0, 0.15);
        display: none;
        left: 100%;
        margin-left: 0;
        max-width: 233px;
        position: absolute;
        top: 0;
        width: 100%;
    }

    .all_conversation ul li:hover .sub_menu_ {
        display: block;
    }

    .new_message_head button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
    }

    .new_message_head {
        background: #f5f3f3 none repeat scroll 0 0;
        float: left;
        font-size: 13px;
        font-weight: 600;
        padding: 18px 10px;
        width: 100%;
    }

    .message_section {
        border: 1px solid #dddddd;
    }

    .chat_area {
        float: left;
        height: 300px;
        overflow-x: hidden;
        overflow-y: auto;
        width: 100%;
    }

    .chat_area li {
        padding: 14px 14px 0;
    }

    .chat_area li .chat-img1 img {
        height: 40px;
        width: 40px;
    }

    .chat_area .chat-body1 {
        margin-left: 50px;
    }

    .chat-body1 p {
        background: #fbf9fa none repeat scroll 0 0;
        padding: 10px;
    }

    .chat_area .admin_chat .chat-body1 {
        margin-left: 0;
        margin-right: 50px;
    }

    .chat_area li:last-child {
        padding-bottom: 10px;
    }

    .message_write {
        background: #f5f3f3 none repeat scroll 0 0;
        float: left;
        padding: 15px;
        width: 100%;
    }

    .message_write textarea.form-control {
        height: 70px;
        padding: 10px;
    }

    .chat_bottom {
        float: left;
        margin-top: 13px;
        width: 100%;
    }

    .upload_btn {
        color: #777777;
    }

    .sub_menu_>li a,
    .sub_menu_>li {
        float: left;
        width: 100%;
    }

    .member_list li:hover {
        background: #428bca none repeat scroll 0 0;
        color: #fff;
        cursor: pointer;
    }
</style>
<script src="https://use.fontawesome.com/45e03a14ce.js"></script>
<div class="main_section">
    <hr>
    <div class="container">
        <div class="chat_container">
            <div class="col-sm-3 chat_sidebar">
                <div class="row">
                    <div class=" all_conversation">
                        <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <a href="<?php echo e(url('admin/messages'), false); ?>">
                                تحديث
                                <i class="fa fa-weixin" aria-hidden="true"></i>
                                <span class="caret pull-right"></span>
                            </a>
                        </button>
                    </div>
                    <div class="member_list">
                        <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <ul class="list-unstyled">
                            <li class="left clearfix">
                                <a href="<?php echo e(url('admin/messages/'.$conversation->id), false); ?>">
                                    <span class="chat-img pull-left"><img src="<?php echo e((!empty($conversation->one->avatar)? $conversation->one->avatar: url('avatar.png')), false); ?>" alt="User Avatar" class="img-circle"></span>
                                    <div class="chat-body clearfix">
                                        <div class="header_sec">
                                            <strong class="primary-font"><?php echo e($conversation->one->name, false); ?></strong>
                                        </div>
                                    </div>
                                    <br>
                                    <span class="chat-img pull-left"><img src="<?php echo e(!empty($conversation->two->avatar)? $conversation->two->avatar: url('avatar.png'), false); ?>" alt="User Avatar" class="img-circle"></span>
                                    <div class="chat-body clearfix">
                                        <div class="header_sec">
                                            <strong class="primary-font"><?php echo e($conversation->two->name, false); ?></strong>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <!--chat_sidebar-->
            <?php if(isset($messages) && $messages->count() > 0): ?>
            <div class="col-sm-9 message_section">
                <div class="row">
                    <div class="new_message_head">
                    </div>
                    <!--new_message_head-->
                    <div class="chat_area">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="left clearfix">
                                <span class="chat-img1 pull-left"><img src="<?php echo e((!empty($message->user->avatar)? $message->user->avatar: url('avatar.png') ), false); ?>" alt="User Avatar" class="img-circle"></span>
                                <div class="chat-body1 clearfix">
                                    <br>
                                    <?php if($message->type==1): ?>
                                    <p><?php echo e($message->text, false); ?></p>
                                    <?php elseif($message->type==2): ?>
                                    <figure>
                                        <figcaption>Listen to the T-Rex:</figcaption>
                                        <audio controls src="<?php echo e($message->text, false); ?>">
                                            Your browser does not support the
                                            <code>audio</code> element.
                                        </audio>
                                    </figure>
                                    <?php else: ?>
                                    <p><img style="max-width:400px" src="<?php echo e($message->text, false); ?>"></p>
                                    <?php endif; ?>
                                    <div class="chat_time pull-right"><?php echo e(\Carbon\Carbon::parse($message->created_at)->format('h:m') .' ' . \Carbon\Carbon::parse($message->created_at)->format('Y-m-d'), false); ?></div>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <!--chat_area-->
                    <div class="message_write">
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="col-sm-9 message_section">
                <div class="row">
                    <div class="new_message_head">
                    </div>
                    <!--new_message_head-->
                    <div class="chat_area">
                        <ul class="list-unstyled">
                            <li class="left clearfix">
                                <span class="chat-img1 pull-left"><img src="<?php echo e((!empty($message->user->avatar)? $message->user->avatar: url('avatar.png')), false); ?>" alt="User Avatar" class="img-circle"></span>
                                <div class="chat-body1 clearfix">
                                    <p> اختار محادثه للعرض</p>
                                    <div class="chat_time pull-right">00:00PM</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--chat_area-->
                    <div class="message_write">
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div> 