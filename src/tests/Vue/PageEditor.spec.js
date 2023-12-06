import { mount } from 'vue-test-utils';
import expect from 'expect';
import PageEditor from "../../resources/js/Shared/PageEditor";

describe('PageEditor', () => {

    let wrapper;

    beforeEach(() => {
        wrapper = mount(PageEditor);
    })

    it('should default to empty editor', function () {
        expect(wrapper.vm.blocks.length).toBe(0)
    });

    it('should have preset blocks', function () {
        expect(wrapper.vm.presets.length).toBeGreaterThan(1)
    });

})
