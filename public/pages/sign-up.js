window.onload = function () {
    var app = new Vue({
        el: '#sign_up',
        data: {
            user: {
                email: '',
                password: '',
                fullname: '',
                confirm: '',
                role: 1,
            }
        },
        methods: {
            submit: function () {
                if (this.password === this.confirm)
                {
                    $.post("/submit-register", this.user, function (data, status) {
                        window.location.href = '/'
                    });
                }
            }
        }
    });
}