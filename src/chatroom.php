<style type="text/css">
    #user_list
    {
        height:450px;
        overflow-y: auto;
    }

    #messages_area
    {
        height: 650px;
        overflow-y: auto;
        background-color:#e6e6e6;
    }

    .aks-multiselect .dropdown-toggle,
    select.akstyle .dropdown-toggle {
        padding: 0;
        min-height: auto;
        background-color: transparent;
    }

    .aks-multiselect .dropdown-toggle::after,
    select.akstyle .dropdown-toggle::after {
        /* rimuovo la freccia di default del dropdown per visualizzare la freccia default della select*/
        border: none;
    }

    .aks-research-bar .aks-multiselect,
    .aks-research-bar select.akstyle {
        background-color: #ffffff;
    }

    .aks-search-line .aks-multiselect,
    .aks-search-line select.akstyle {
        padding: 6px 15px;
        font-size: 13px;
    }

    .bootstrap-select.aks-multiselect-customize .dropdown-menu li a {
        font-size: 12px;
        padding: 1px 5px;
        border-bottom: 1px solid #eef0f3;
    }

    /***********/
    /* mio css */
    /***********/

    .aks-multiselect,
    select.akstyle {
        width: 70% !important; /*larghezza della select modificata */
        background-color: #eef0f3;
        color: #212529;
        border: none;
        padding: 8px 15px;
        font-size: 13px;
        font-weight: 800;
        border-radius: 50px;
        cursor: pointer;
    }

    .list-group-item-action:hover, .list-group-item-action:active, .list-group-item-action:focus, .dropdown-item:hover, .dropdown-item:active, .dropdown-item:focus {
        background-color: white !important;
    }

    .list-group-item-action:hover {
        color: black;
    }

    .dropdown-item {
         padding: 0;
    }

    .bootstrap-select.show-tick .dropdown-menu .selected span.check-mark {
        top: 20px;
    }

    .img-thumbnail {
        padding: 0;
    }

    .cont {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, 250px) !important;
    }

    .bootstrap-select.show-tick .dropdown-menu li a span.text {
        margin-right: 0;
    }

    .btn-light, .btn-light:active, .btn-light:focus, .btn-light:hover {
        background-color: transparent;
        border-color: transparent;
    }

    #aaa {
        transform: translate(15px, 80px) !important;
    }

    .bootstrap-select .dropdown-toggle:focus, .bootstrap-select > select.mobile-device:focus + .dropdown-toggle {
        outline: 0 !important;
        outline-offset: -2px;
    }

    button:focus:not(:focus-visible) {
        outline: 0 !important;
    }

    .btn-check:focus + .btn-light, .btn-light:focus {
        color: transparent !important;
        background-color: transparent !important;
        border-color: transparent !important;
        box-shadow: none !important;
    }

    .btn-check:focus + .btn, .btn:focus {
        outline: 0;
        box-shadow: none !important;
    }

    .bootstrap-select>select {
        left: 0;
    }

    .aks-multiselect {
        min-height: 75px;
    }
</style>

<div class="row mt-3 ml-2">
    <div class="col-9">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm-6">
                        <h3>Chat Title</h3>
                    </div>
                    <div class="col col-sm-6 text-end">
                        <button class="btn btn-primary float-right" id="create_room" data-bs-toggle="modal" data-bs-target="#exampleModal" style="height: 40px;"><i class="fas fa-user-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body" id="messages_area">
            <?php foreach($chat_data as $chat) {
                if((int)$_SESSION['userid'] === (int)$chat['userid']) {
                    $from = 'Me';
                    $row_class = 'row justify-content-start';
                    $background_class = 'text-dark alert-light';
                } else {
                    $from = $chat['user_name'];
                    $row_class = 'row justify-content-end';
                    $background_class = 'alert-success';
                } // fine if

                echo '
                <div class="'.$row_class.'">
                    <div class="col-sm-10">
                        <div class="shadow-sm alert '.$background_class.'">
                            <b>'.$from.' - </b>'.$chat["msg"].'
                            <br />
                            <div class="text-right">
                                <small><i>'.$chat["created_on"].'</i></small>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            } // end foreach ?>
            </div>
        </div>

        <form method="post" id="chat_form" class="mt-3">
            <div class="input-group mb-3">
                <textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" required></textarea>&nbsp;&nbsp;
                <div class="input-group-append">
                    <button type="submit" name="send" id="send" class="btn btn-primary h-100"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
            <div id="validation_error"></div>
        </form>
    </div>
    <div class="col-3">
        <?php $login_user_id = $_SESSION['userid']; ?>
        <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
        <div class="mt-3 mb-3 text-center">
            <img src="gdpr.png" width="150" class="img-fluid rounded-circle img-thumbnail" />
            <h3 class="mt-2"><?php echo $_SESSION['name']; ?></h3>
            <input type="button" class="btn btn-primary mt-2 mb-2" name="logout" id="logout" value="Logout" />
        </div>

        <div class="card mt-3" style="margin-right: 25px;">
            <div class="card-header">User List</div>
            <div class="card-body" id="user_list">
                <div class="list-group list-group-flush">
                <?php if(count($user_data) > 0) {
                    foreach($user_data as $key => $user) {
                        $icon = '<i class="fa fa-circle text-danger"></i>';
                        if($user['user_login_status'] === 'Login') $icon = '<i class="fa fa-circle text-success"></i>';

                        if((int)$user['user_id'] !== $login_user_id) {
                            echo '<a class="list-group-item list-group-item-action">
                                <img src="gdpr.png" class="img-fluid rounded-circle img-thumbnail" width="50"/>
                                <span class="ml-1"><strong>'.$user["user_name"].'</strong></span>
                                <span class="mt-2 float-right">'.$icon.'</span>
                                <button type="button" name="chat-with" id="chat-with" class="btn btn-primary float-end mt-2"><i class="fa-solid fa-comment-dots"></i></button>
                            </a>';
                        } // fine if
                    } // fine foreach
                } // fine if ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var conn = new WebSocket('wss://127.0.0.1/wss2/');

		conn.onopen = function(e) {
		    console.log("Connection established!");
            var data = {
                auth: "<?php echo $token; ?>"
            };

            conn.send(JSON.stringify(data));
		};

		conn.onmessage = function(e) {
		    console.log(e.data);
		    var data = JSON.parse(e.data);
		    var row_class = '';
		    var background_class = '';
		    if(data.from == 'Me') {
		    	row_class = 'row justify-content-end';
                background_class = 'text-dark alert-light';
            } else {
		    	row_class = 'row justify-content-start';
                background_class = 'alert-success';
            } // fine if

		    var html_data = "<div class='"+row_class+"'><div class='col-sm-10'><div class='shadow-sm alert "+background_class+"'><b>"+data.from+" - </b>"+data.msg+"<br /><div class='text-right'><small><i>"+data.dt+"</i></small></div></div></div></div>";
		    $('#messages_area').append(html_data);
		    $("#chat_message").val("");
		};

		$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

		$('#chat_form').on('submit', function(event){
			event.preventDefault();

            var user_id = $('#login_user_id').val();
            var message = $('#chat_message').val();
            var data = {
                userid : user_id,
                msg : message
            };

            conn.send(JSON.stringify(data));
            $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
		});

		$('#logout').click(function(){
			let user_id = $('#login_user_id').val();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{user_id:user_id, action:'leave'},
				success:function(data)
				{
					var response = JSON.parse(data);

					if(response.status == 1) {
						conn.close();
						window.location = 'index.php';
					} // fine if
				},
                error:function(data)
                {
                    console.log(data);
                } // fine error
			}); // fine ajax
		}); // fine evento

        $("ul.dropdown-menu").addClass("cont");
        $(".filter-option-inner-inner").addClass("cont");
        $('.bs-searchbox').parent().attr("id", "aaa");
    }); // fine document-ready

    $.fn.selectpicker.Constructor.DEFAULTS.multipleSeparator = ' ';
    $('.selectpicker').selectpicker();


    $('#add-user-chat').on('click', function(event) {
        $("select#multiple-select > option:selected").each(function() {
            let optionText = $.parseHTML(this.attributes[2].nodeValue)[0].children[1].children[0].textContent;
            //console.log(optionText + ' - ' + this.value);
        });
    }); // fine evento
</script>
</html>
