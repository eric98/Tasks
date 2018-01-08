import { mount } from 'vue-test-utils'
import expect from 'expect'
import Users from '../../resources/assets/js/components/Users.vue'
import moxios from 'moxios'

describe('Users', () => {
  let component

  const USERS = [
    {
      id: 1,
      name: 'Hector',
      email: 'hector@gmail.com'
    },
    {
      id: 2,
      name: 'Claudia',
      email: 'claudia@gmail.com'
    },
    {
      id: 3,
      name: 'Zelda',
      email: 'zelda@gmail.com'
    }
  ]

  beforeEach(() => {
    component = mount(Users)
    moxios.install()
  })

  afterEach(() => {
    moxios.uninstall()
  })

  it('contains Users', () => {
    expect(component.html()).toContain('Users (3):')
  })

  it('expect users empty', () => {
    expect(component.vm.users).toEqual([])
  })

  it('contains correct number of users after mount', done => {

    // 1 Prepare
    moxios.stubRequest('/api/v1/users', {
      status: 200,
      response: USERS
    })

    moxios.wait( () => {
      expect(component.vm.users).toEqual(USERS)
      expect(component.html()).toContain('Users (3):')
      done()
    })

    // 2 Execute

    // 3 ASSERT

  })

})