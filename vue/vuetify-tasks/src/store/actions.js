import * as types from './mutation-types'
import * as actionTypes from './action-types'
import tasks from '../api/tasks'

export default {
  [ actionTypes.INCREMENT ] (context) {
    context.commit('increment')
  },

  [ actionTypes.FETCH_TASKS ] (context) {
    context.commit(types.SET_TASKS, tasks.fetch())
  }
}
