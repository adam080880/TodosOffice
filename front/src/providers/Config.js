const Config = {
    urlApi: "http://localhost:8000/api/",
    api: function(_path) {
        return this.urlApi + _path
    }
}

export default Config