var listApi = ["xhr", "ajax", "axios", "fetch", "dom", "form", "request"];
listApi.map(function (fnc) {
    if (App[fnc]) {
        App.query[fnc] = App[fnc];
    }
})

var loadedCallbacks = [];
App.tasks = App.prototype.tasks = [];
App.ready = App.prototype.ready = App.run = App.prototype.run = App.task = App.prototype.task = function (task) {
    if (typeof task == "function") {
        var queryEngine = App.getSystemOption("queryEngine");

        if (documentReady()) {
            var query = isString(queryEngine) && queryEngine.toLowerCase() == "jquery" && global.jQuery ? global.jQuery : App.query;
            try {
                task(query);
            } catch (error) {
                App.log(error);
            }

        } else {
            App.tasks.push(App.queue(function (resolve, reject) {
                try {
                    if (documentReady()) {
                        var query = isString(queryEngine) && queryEngine.toLowerCase() == "jquery" && global.jQuery ? global.jQuery : App.query;
                        task(query);
                        return resolve("thành công");
                        // return false;
                    }
                } catch (error) {
                    return reject(error);
                }

            }, 50).step(500).catch(rs => App.log(rs)));
        }

    }
};

App.onModuleLoaded = App.prototype.onModuleLoaded = function(callback, params){
    if(typeof callback == "function"){
        loadedCallbacks.push({
            cb: callback,
            args: Array.isArray(params)?params:[]
        })
    }
};

App.dispatchModuleLoaded = App.prototype.dispatchModuleLoaded = function(){
    while(loadedCallbacks.length > 0){
        loadedCallbacks[0].cb.apply(App, loadedCallbacks[0].args);
        loadedCallbacks.splice(0, 1);
    }
}