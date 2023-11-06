const Api : any = {
    Test: process.env.API + "self",
    Login: process.env.API + "login",
    tokenRefresh: process.env.API + "token-refresh",
}

export default Api