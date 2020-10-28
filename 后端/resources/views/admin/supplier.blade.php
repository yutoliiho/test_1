<style>
    .supplier {
        background: rgba(226, 225, 225, 0.25);
        border-radius: 3px;
        padding: 12px;
        border: 1px solid rgba(197, 197, 197, 0.6);
    }
</style>
<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">
    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <input type="hidden" name="{{$name}}" value="{{ old($column, $value) }}"/>
    <div class="{{$viewClass['field']}}" data-name="{{ $name }}">
        @include('admin::form.error')
        <span class="help-block">
            <i class="fa fa-help"></i>&nbsp;<span class="helptext"></span>
        </span>
        <div class="supplier" id="{{$id}}">
            <div class="form-group">
                <label for="supSelect" class="col-sm-2 control-label">供应商</label>
                <div class="col-sm-8">
                    <input type="hidden" name="supSelect">
                    <select class="form-control supSelect select2-hidden-accessible" style="width: 100%;"
                            name="supSelect" data-value="" tabindex="-1" aria-hidden="true">
                        <option value=""></option>
                        @foreach($supData as $select => $option)
                            <option value="{{$option['id']}}">{{$option['text']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="supDATASelect" class="col-sm-2 control-label">供应商数据</label>
                <div class="col-sm-8">
                    <div class="box box-solid box-default no-margin datahelp">
                        <div class="box-body">
                            请在上方选择供应商
                        </div>
                    </div>
                    <input type="hidden" name="supDATASelect">
                    <select class="form-control supDATASelect select2-hidden-accessible" style="width: 100%;"
                            name="supDATASelect" data-value="" tabindex="-1" aria-hidden="true">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="supLoadData" class="col-sm-2  control-label">加载到的数据</label>
                <div class="col-sm-8">
                    <div id="supLoadData" style="width: 100%; height: 100%;"></div>
                    <input type="hidden" name="supLoadData" value=""/>
                </div>
            </div>

            <div class="form-group">
                <label for="productData" class="col-sm-2 control-label">数据</label>
                <div class="col-sm-8" id="navbs">
                    {!! $tabObj !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12" style="text-align: center;">
                    <button type="button" class="btn btn-primary" style="width: 100%" id="dataSure">确定数据</button>
                </div>
            </div>
        </div>
        @include('admin::form.help-block')
    </div>
</div>