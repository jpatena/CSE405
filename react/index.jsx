/*global React*/
/*global ReactDOM*/
/*global ajax*/

var LogoutButton = React.createClass({
    onLogout: function() {
        ajax('logout.php', null, function(response) {
            if (response.result === 'error') {
                alert('Error: ' + response.msg);
            } else
                this.props.onLogout();
        }.bind(this));
    },
    render: function() {
        return (
            <div>
                <input type='submit' value='Logout' onClick={this.onLogout} /><br/>
            </div>
        );
    }
});

var LoginForm = React.createClass({
    getInitialState: function() {
        return {
            username: 'ruby',
            password: '1234'
        };
    },
    onUsernameChange: function(e) {
        this.setState({username: e.target.value});
    },
    onPasswordChange: function(e) {
        this.setState({password: e.target.value});
    },
    onSubmit: function(e) {
        // send username and password in an ajax request to server
        ajax('login.php', { username: this.state.username, password: this.state.password }, function(response) {
            if (response.result === 'failure') {
               alert('Bad username or password');
            } else if (response.result === 'success') {
                this.props.onLogin(response.clickCount);
            } else if (response.result === 'error') {
                alert('Error: ' + response.msg);
            } else {
                alert('Response message has no result attribute.');
            }
        }.bind(this)); // returns another function
       
    },
    render: function() {
        return (
            <div>
                Username: <input type='text'    onChange={this.onUsernameChange} value={this.state.username} /><br/>
                Password: <input type='password'onChange={this.onPasswordChange} value={this.state.password} /><br/>
                          <input type='submit'  onClick={this.onSubmit}          value='Login'/>
            </div>
        );
    }
});

var ClickButton = React.createClass({
    onClick: function() {
        ajax('record_click.php', null, function(response) {
            if (response.result === 'success') {
                this.props.setClicks(response.clickCount);
            } else if (response.result === 'error') {
                alert('Error: ' + response.msg);
            } else {
                alert('Response message has no result attribute.');
            }
        }.bind(this)); // returns another function
    },
    render: function() {
        return <input type='submit' value='Click Me' onClick={this.onClick} />;
    }
});

var ClickScreen = React.createClass({
    render: function() {
        return (
            <div>
                <div>Click count: {this.props.clickCount} </div>
                <ClickButton setClicks={this.props.setClicks} />
                <LogoutButton onLogout={this.props.onLogout} />
            </div>
        );
    }    
});

var LoadingScreen = React.createClass({
    render: function() {
        return <div>Loading...</div>;
    }
});

var LoginScreen = React.createClass({
    render: function() {
        return <LoginForm onLogin={this.props.onLogin} />;
   } 
});



var App = React.createClass({
    getInitialState: function() {
        // clickCount set to null when not logged in
        return {
            loading: true,
            clickCount: null
        };
    },
    componentDidMount: function() {
        ajax('init.php', null, function(response) {
            if (response.result === 'error') {
                alert('Error: ' + response.msg);
            } else if (response.result === 'loggedIn') {
                this.setState({ loading: false, clickCount: response.clickCount, });
            } else if (response.result === 'notLoggedIn') {
                this.setState({ loading: false, clickCount: null, });
            } else {
                alert('Response message has no result attribute');
            }
        }.bind(this));
    },
    onLogin: function(clickCount) {
        this.setState({ clickCount: clickCount });
    },
    onLogout: function() {
        this.setState({ clickCount: null });
    },
    setClick: function(clickCount) {
        this.setState({ clickCount: clickCount });
    },
    render: function() {
        if (this.state.loading) {
            return <LoadingScreen />;
        } else if (this.state.clickCount === null) {
            return <LoginScreen onLogin={this.onLogin} />;
        } else {
            return (
                <ClickScreen
                    clickCount={this.state.clickCount}
                    setClicks={this.setClick}
                    onLogout={this.onLogout}
                />
            );    
        }
    }
});    

ReactDOM.render(<App />, document.getElementById('content'));





