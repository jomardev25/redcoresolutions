import toastr from "toastr";

toastr.options = {
    "progressBar": true,
    "preventDuplicates": true,
    "newestOnTop": true
};

export default {
    success(message, title = "Success", options = {}){
        toastr.success(message, title, options);
    },

    error(message, title = "Error", options = {}){
        toastr.error(message, title, options);
    },

    info(message, title = "Info", options = {}){
        toastr.info(message, title, options);
    },

    warning(message, title = "Warning", options = {}){
        toastr.warning(message, title, options);
    }
};
