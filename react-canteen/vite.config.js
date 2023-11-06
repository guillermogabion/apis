import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import dotenv from 'dotenv'
// https://vitejs.dev/config/

dotenv.config()
export default defineConfig({
  plugins: [react()],
  server: {
    port: Number(process.env.PORT)
  },
  define : {
    'process.env.PORT' : `${process.env.PORT}`,
    'process.env.API' : `"${process.env.API}"`,
    'process.env.REACT_APP_ENCRYPTION_KEY' : `"${process.env.REACT_APP_ENCRYPTION_KEY}"`,
    'process.env.DEFAULT_LANGUAGE' : `"${process.env.DEFAULT_LANGUAGE}"`,
  }
})
