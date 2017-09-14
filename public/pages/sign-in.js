window.onload = function () {
    var app = new Vue({
        el: '#sign_in',
        data: {
            user: {
                email: '',
                password: ''
            }
        },
        methods: {
            submit: function () {
                console.log(this.user);
                // axios.post('/submit-login', this.user).then(result => {
                //     console.log(result);
                // });
                $.post("/submit-login", this.user, function (data, status) {
                        console.log("Data: " + data + "\nStatus: " + status);
                });
            }
        }
    });
}