<div class="template-item-team hidden">
    <div class="row item-team">
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-12 control-label">@lang('app.fonction')</label>
                <div class="col-md-12">
                    <select class="form-control" name="function_team[]">
                        <option value="CEO">CEO</option>
                        <option value="CT0">CTO</option>
                        <option value="COO">COO</option>
                        <option value="CSO">CSO</option>
                        <option value="CMO">CMO</option>
                        <option value="CFO">CFO</option>
                    </select>
                </div>
                <label class="remove-team">@lang('app.remove')</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-12 control-label">
                    @lang('app.name')/@lang('app.first_name') *</label>
                <div class="col-md-12">
                    <input id="team_name" type="text" class="form-control" name="name_team[]" required
                           value="">

                </div>
            </div>
        </div>
        <div class="col-md-4 social-network-link">
            <div class="form-group">
                <label class="col-md-12 control-label">@lang('app.social_network_link')</label>

                <div class="item-link input-group">
                    <span class="input-group-addon linkedin"><i class="fa fa-linkedin"></i></span>
                    <input type="text" class="form-control social_network_link" name="social_network_team[][0]">
                </div>
                <div class="item-link input-group">
                    <span class="input-group-addon facebook"><i class="fa fa-facebook"></i></span>
                    <input type="text" class="form-control social_network_link" name="social_network_team[][1]">
                </div>
                <div class="item-link input-group">
                    <span class="input-group-addon twitter"><i class="fa fa-twitter"></i></span>
                    <input type="text" class="form-control social_network_link" name="social_network_team[][2]">
                </div>
            </div>

        </div>
    </div>
</div>
<div class="template-item-link hidden">
    <div class="col-md-12 item-link">
        <input id="name_team" type="text" class="form-control" name="social_network_team[][]"
               value="" required>
        <span class="remove-item small">-</span>
    </div>
</div>