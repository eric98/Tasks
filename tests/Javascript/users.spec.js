import {mount} from 'vue-test-utils'
import expect from 'expect'
import Users from '../../resources/assets/js/components/Users.vue'

describe('Users', () => {
    let component

    beforeEach(() => {
        component = mount(Users)
    })

    it('contains example', () => {
        expect(component.html()).toContain('example')
    })

    it('expect users empty', () => {
        expect(component.vm.users).toEqual([])
    })

})