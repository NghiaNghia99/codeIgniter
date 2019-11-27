<div class="section-tell-us">
  <div class="title sm-title big-font-normal">
    Tell us
  </div>
  <div class="sm-block block-white">
    <form method="post">
      <div class="text-before">
        Do you have any comments, feedback, ideas for enhancements, etc.? Please feel free to send us your requests
        below.
      </div>
      <div class="form-group form-item">
        <label class="form-label label-custom">Comments</label>
        <textarea class="form-control textarea-custom countCharacters" name="comment-tell-us"
                  placeholder="Please your comments here! Please limit your comments to 3000 characters."><?php echo set_value('comment') ?></textarea>
        <div class="gr-text-after text-after-textarea">
          <div class="text-left">
            <div class="error"><?php echo form_error('comment') ?></div>
          </div>
          <div class="text-right">
            <input type="hidden" class="limit-character" value="3000">
            You have <span id="charNumber">3000</span> characters left
          </div>
        </div>
      </div>
      <div class="button-bottom">
        <button type="submit" class="add-spinner btn-custom btn-bg green btn-send">
          Send
        </button>
      </div>
    </form>
  </div>
</div>