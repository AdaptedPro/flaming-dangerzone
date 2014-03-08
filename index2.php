<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Hello, world!</h1>
    <hr />
    <h2>What do you need?</h2>
    
    <form id="c_form" action="">
        <ul>
            <li><p><input type="checkbox" name="q_1" id="q_1" value="1" class="r_data" />&nbsp;I need help with my website.</p>
                <div class="follow_up">
                    <strong>Do you currently have a website?</strong>
                    <ul>
                        <li><input type="radio" name="q_1a" id="q_1a_1" value="Y" class="r_data" />&nbsp;Yes
                            <div class="follow_up">
                                <strong>Is your website currently online?</strong>
                                <ul>
                                    <li><input type="radio" name="q_1a_i" id="q_1a_iy" value="Y" class="r_data" />&nbsp;Yes, located here: <input type="text" size="30" maxlength="50" value="" placeholder="http://www.example.com"/></li>
                                    <li><input type="radio" name="q_1a_i" id="q_1a_in" value="N" class="r_data" />&nbsp;No
                                        <div class="follow_up">
                                            <strong>Do you have the files in your possesion?</strong>
                                            <ul>
                                                <li><input type="radio" name="q_1a_i_1" id="q_1a_i_1y" value="Y" class="r_data" />&nbsp;Yes</li>
                                                <li><input type="radio" name="q_1a_i_1" id="q_1a_i_1n" value="N" class="r_data" />&nbsp;No</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><input type="radio" name="q_1a" id="q_1a_2" value="N" class="r_data" />&nbsp;No</li>
                    </ul>
                </div>
            </li>
            <li><input type="checkbox" name="q_2" id="q_2" value="2" class="r_data" />&nbsp;I need a mobile app created.
            </li>
            <li><input type="checkbox" name="q_3" id="q_3" value="3" class="r_data" />&nbsp;I need graphic design services.
            </li>
        </ul>    	
    	<input type="submit" value="Request Quote." />
    </form>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>