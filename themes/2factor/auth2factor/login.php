<?php

$this->includeAtTemplateBase('includes/header.php');

?>

<?php if ( $this->data['todo'] == 'selectauthpref' ) : ?>
    <h1>Authentication method</h1>
<?php elseif ( $this->data['todo'] == 'selectanswers' ) : ?>
    <h1><?php echo $this->t('{auth2factor:login:2step_title}')?></h1>
<?php elseif ( $this->data['todo'] == 'loginCode' ) : ?>
    <h1><?php echo ($this->t('{auth2factor:login:mailcode}'))?></h1>
<?php elseif ( $this->data['todo'] == 'loginANSWER' ) : ?>
    <h1>Please answer the question below</h1>
<?php endif; ?>

</div><!-- #login-header -->

<?php if ($this->data['errorcode'] !== NULL) :?>
  <div class="alert">
    <p><strong><?php echo $this->t('{login:error_header}'); ?> - <?php echo $this->t('{auth2factor:errors:title_' . $this->data['errorcode'] . '}'); ?></strong></p>
    <p><?php echo $this->t('{auth2factor:errors:descr_' . $this->data['errorcode'] . '}'); ?></p>
  </div>

<?php endif; ?>

<form action="?" method="post" name="f" id="form">

    <?php if ( $this->data['todo'] == 'selectauthpref' ) : ?>
        <div class="help-text">
            <h3>Please select your preferred method of authentication</h3>
            <ul class="auth-options">
                <li><input type="radio" name="authpref" id="qanda" value="qanda" checked="checked"><label for="qanda">Secret question &amp; answers</label></li>
                <li><input type="radio" name="authpref" id="pin" value="pin"><label for="pin">OTP (One Time Password) sent via email</label></li>
            </ul>
            <p class="small">For future login attempts, the above selected preference will be applied. There will be an option to switch to the other method of authentication if required.</p>

            <input class="submitbutton btn btn-block" type="submit" tabindex="2" name="submit" value="<?php echo $this->t('{auth2factor:login:next}')?>" />
        </div>

    <?php elseif ( $this->data['todo'] == 'selectanswers' ) : ?>
        <p>
          <?php

            if(!empty($this->data['questions'])) {
              for($i=1;$i <=3; $i++){
                $answer_value = "";
                $question_value = "";

                if(isset($_POST["answers"]) && isset($_POST["questions"])){
                  // TODO SECURITY - Fix for XSS! santize the input $_POST
                  $answer_value = $_POST["answers"][$i-1];
                  $question_value = $_POST["questions"][$i-1];
                  $selected_qid = $_POST["questions"][$i-1];
                }
                // Row Colouring
                if($i % 2) $row = "row";
                        else $row = "row alternate";

                echo ('<div class="'.$row.'">');
                echo '<select id="question_'. $i .'" class="form-control small questions" name="questions[]" required="requred">';
                echo '<option value="0">--- select question ---</option>';
                foreach($this->data['questions'] as $question => $q) {
                  $selected = "";

                  if (isset($_POST["questions"])){
                    if ($selected_qid == $q["question_id"]){
                      $selected = " selected";
                    }
                  }
                  echo ('<option value="'.$q['question_id'].'"'. $selected . '>'.$q['question_text'].'</option>');
                }
                echo '<option class="custom" value="question_'.$i.'">Write your own question ...</option>';
                echo '</select>';

                echo '<input style="display: none;" autocomplete="off" autocorrect="off" autocapitalize="off" class="form-control small question_'.$i.'" placeholder="Question" name="custom_questions[]" value="'.$question_value. '" type="text" pattern=".{'.$this->data['minQuestionLength'].',}"';
                echo ' title="Question must be at least '.$this->data['minQuestionLength'].' characters long">';

                echo '<input autocomplete="off" autocorrect="off" autocapitalize="off" class="form-control small" placeholder="Answer" name="answers[]" value="'.$answer_value. '" type="text" pattern=".{'.$this->data['minAnswerLength'].',}"';
                echo ' title="Answers must be at least '.$this->data['minAnswerLength'].' characters long" required="requred">';

                echo '</div>';
              }
            }
          ?>
    <?php if ( $this->data['minAnswerLength'] > 0 ) : ?>
    <?php endif; ?>
          <input class="btn btn-block" type="submit" tabindex="2" name="submit" value="<?php echo $this->t('{auth2factor:login:next}')?>" >
        </p>

    <?php elseif ( $this->data['todo'] == 'loginANSWER' ) : ?>
        <h2><?php echo $this->data["random_question"]["question_text"]; ?>?</h2>
        <div class="form-controls">
            <input type="hidden" value="<?php echo $this->data['random_question']['question_id'];?>" name="question_id" >
            <input autocomplete="off" autocorrect="off" autocapitalize="off" id="answer" class="form-control password-box" type="password" tabindex="1" name="answer" >
        </div>
        <p><input id="submit" class="btn btn-block" type="submit" tabindex="2" name="submit" value="<?php echo $this->t('{auth2factor:login:next}')?>" />
        </p>

    <?php elseif ( $this->data['todo'] == 'loginCode' ) : ?>
        <div class="loginbox">
            <h3><?php echo ($this->t('{auth2factor:login:entermailcode}')); ?></h3>
            <div class="form-controls">
            <p><input autocomplete="off" autocorrect="off" autocapitalize="off" id="answer" class="form-control" type="text" tabindex="1" name="answer" /></p>
            </div>
            <p>
            <input id="submit" class="submitbutton btn btn-block" type="submit" tabindex="2" name="submit" value="<?php echo $this->t('{auth2factor:login:next}')?>"/>

            </p>
        </div>

<?php endif; ?>

<?php
foreach ($this->data['stateparams'] as $name => $value) {
  echo('<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" />');
}
?>


<div id="login-footer">
<?php if ( $this->data['todo'] == 'loginCode' ) : ?>
    <p>
        <a href="#" id="link-help">Help</a> &middot;
        <input class="submitbutton btn btn-link" type="submit" tabindex="3" name="submit" value="<?php echo $this->t('{auth2factor:login:switchtoq}')?>" /> &middot;
        <input id="resent" class="submitbutton btn btn-link" type="submit" tabindex="2" name="submit" value="<?php echo $this->t('{auth2factor:login:resend}')?>"/>
    </p>
<?php elseif ( $this->data['todo'] == 'loginANSWER' ) : ?>
    <p> <a href="#" id="link-help">Help</a> &middot;
        <input class="btn btn-link" type="submit" tabindex="3" name="submit" value="<?php echo $this->t('{auth2factor:login:switchtomail}')?>" /> &middot;
        <input id="resetquestions" class="btn btn-link" type="submit" tabindex="4" name="submit" value="<?php echo $this->t('{auth2factor:login:resetquestions}')?>"/>
    </p>
<?php else: ?>
    <p><a href="#" id="link-help">Help</a></p>
<?php endif; ?>
</div>

</form>

<script type="text/javascript">
    $( ".questions" ).change(function() {
         $('.'+$(this).attr('id')).prop('required',false);
         $('.'+$(this).val()).val(''); // reset value to empty if the user changes mind
         $('.'+$(this).attr('id')).hide();
        if ($(this).find('option:selected').attr('class') == 'custom') {
            $('.'+$(this).val()).show();
            $('.'+$(this).val()).prop('required',true);;
        }
    });
</script>

</div> <!-- #login-box -->
</div> <!-- #wrap -->
</body>
</html>
