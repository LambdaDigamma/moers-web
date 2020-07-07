export default class Utilities {

    static convertModelToFormData(data = {}, form = null, namespace = '') {
        let files = {};
        let model = {};
        for (let propertyName in data) {
            if (data.hasOwnProperty(propertyName) && data[propertyName] instanceof File) {
                files[propertyName] = data[propertyName]
            } else {
                model[propertyName] = data[propertyName]
            }
        }

        model = JSON.parse(JSON.stringify(model))
        let formData = form || new FormData();

        for (let propertyName in model) {
            if (!model.hasOwnProperty(propertyName) || !model[propertyName]) continue;
            let formKey = namespace ? `${namespace}[${propertyName}]` : propertyName;
            if (model[propertyName] instanceof Date)
                formData.append(formKey, model[propertyName].toISOString());
            else if (model[propertyName] instanceof File) {
                formData.append(formKey, model[propertyName]);
            } else if (model[propertyName] instanceof Array) {
                model[propertyName].forEach((element, index) => {
                    const tempFormKey = `${formKey}[${index}]`;
                    if (typeof element === 'object') this.convertModelToFormData(element, formData, tempFormKey);
                    else formData.append(tempFormKey, element.toString());
                });
            } else if (typeof model[propertyName] === 'object' && !(model[propertyName] instanceof File))
                this.convertModelToFormData(model[propertyName], formData, formKey);
            else {
                formData.append(formKey, model[propertyName].toString());
            }
        }

        for (let propertyName in files) {
            if (files.hasOwnProperty(propertyName)) {
                formData.append(propertyName, files[propertyName]);
            }
        }
        return formData;
    }

}
