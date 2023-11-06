import {
    IS_LOGIN,
    USER_DATA,
    LOGOUT
} from "../action/rootAction"
import { loadState } from "../sessionStorage"
const persistedState = loadState()

interface Action {
    type : string,
    payload : any
}

interface State {
    email: string 
    isLogin: boolean
    userData: any
}

const initialState: any = {
    email: "",
    isLogin: false,
    userData: {},
    ...persistedState,

   
}

export default function rootReducer(state: State = initialState, action: Action) {
    const { payload, type } = action
  
    switch (type) {
    
      case IS_LOGIN:
        return { ...state, isLogin: payload }
      case USER_DATA:
        return { ...state, userData: payload }
      case LOGOUT:
        return {
            ...state,
            isLogin: false, 
            userData: {},
        };
  
      default:
        return state
    }
  }