<div class="row">
    {{#if error}}
    <div class="col-md-12 alert alert-danger">Errore invio</div>
    {{else}}
        {{#if info}}

        <div class="col-md-12 alert alert-success">{{info}}</div>

        {{else}}
            <div class="comment col-sm-12 container-fluid">

                <div class="row">

                    <div class="col-md-2">
                        <img class="imm-profilo-comm" src="./?env=image&op=user_pic&user_id={{user_id}}" alt="Profilo" />
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <span class="comment-user-name"><a href="./?env=user&op=profile&user={{user_id}}">{{user_name}}</a></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="post-date">{{date_h_readable}}</span>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-10 col-sm-offset-1">
                        <p class="text post-text">{{text_content}}</p>
                    </div>

                </div>
            </div>
        {{/if}}
    {{/if}}
</div>