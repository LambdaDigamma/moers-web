import Utilities from "./Utilities.js";

export default class Form {

    constructor(data) {
        this.data = data;
    }

    toFormData(method = "post") {

        let formData = new FormData();
        formData.append('_method', method);

        return Utilities.convertModelToFormData(this.data, formData);

    }

}
