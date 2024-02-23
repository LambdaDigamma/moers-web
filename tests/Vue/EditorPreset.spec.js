import { mount } from 'vue-test-utils';
import expect from 'expect';
import EditorPreset from "../../resources/js/Shared/PageComponents/Editors/EditorPreset";

describe('EditorPreset', () => {

    let wrapper;

    beforeEach(() => {
        wrapper = mount(EditorPreset);
    })

    it('should be emit delete event', function () {
        wrapper.find('#delete').trigger('click')
        expect(wrapper.emitted().deleted).toBeTruthy()
    });

    it('should emit duplicate event', function () {
        wrapper.find('#duplicate').trigger('click')
        expect(wrapper.emitted().duplicated).toBeTruthy()
    });

})
