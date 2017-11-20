var MyBiz = MyBiz || {};

MyBiz.validationHelper = function() {
    this.rawData = {};
    this.messages = {};
    this.rules = {};
    this.formId = ''
    var self = this;
    this.fetch = function(type,fields,formId) {
        self.formId = formId;
        var url = self.createAjaxUrl(type,fields);
        var params = self.createAjaxParams(url);
        ajaxFeed(params);
    };
    this.translate = function() {

        for(key in self.rawData) {
            var len = self.rawData[key].length;

            self.rules[key] = {};
            self.messages[key] = {};
            for (var i = 0; i < len; i++ )
            {
                var rl = self.convertRule(self.rawData[key][i].rule);
                for(vl in rl) {
                    self.rules[key][vl] = rl[vl];
                    self.messages[key][vl] = self.rawData[key][i].message;
                }
            }

        }
        $(self.formId).validate({
            'rules': self.rules,
            'messages': self.messages,
            'submitHandler':function(form) {
                form.submit();
            }
        });

    };
    this.convertRule = function(rule) {
        if(rule == 'required') { return { required:true }; }
        if(rule == 'email') { return { email:true }; }

        var x = rule.split(':');
        var rle = x[0];
        var params = x[1];

        if(rle == 'size') {
            return {
                'minlength':params,
                'maxlength':params
            }
        }
        if(rle == 'min') {
            return {
                'minlength':params
            }
        }
        if(rle == 'same') {
            var sameAsId = params;
            $.validator.addMethod('same',function(value) {
                var v1 = document.getElementById(sameAsId).value;
                return value == v1;
            },'Password must match');
            return {
                'same':true
            }
        }
        if(rle == 'regex') {
            $.validator.addMethod('regexCheck',function(value) {
                return eval(params).test(value)
            },"Password not strong enough");
            return {
                'regexCheck':true
            }
        }
    }


    this.showRawData = function() {
        alert("From Show Raw Data: " + JSON.stringify(self.rawData));
    }
    this.createAjaxUrl = function(type,fields) {
        var url = 'validation-rules/';
        if(type == '') { type = 'all'; }
        url += type + "/";
        for(var i=0; i<fields.length; i++) {
            if(i>0) { url += ","; }
            url += fields[i];
        }
        return url;
    };
    this.createAjaxParams = function(url,callback) {
        return {
            'successCallback': function(data) {
                self.rawData = data.passback;
                self.translate();
            },
            'url': url,
            'data': {},
            'submitType':'GET',
        }
    };
};

