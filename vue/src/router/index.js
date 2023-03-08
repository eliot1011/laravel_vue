import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Services from '@/components/Services'
import profile from '@/components/profile'


import adminLogin from '@/components/Login'

import Test from '@/components/Admin/Test'
import TestEntry from '@/components/Admin/TestEntry'
import UserEntry from '@/components/Admin/UserEntry'


import ResultEntry from '@/components/Lab/ResultEntry'

import PatientEntry from '@/components/Receptionist/PatientEntry'
import PatientList from '@/components/Receptionist/PatientList'
import PatientPayment from '@/components/Receptionist/PatientPayment'
import PrintRecept from '@/components/Receptionist/PrintRecept'
import LatestPatient from '@/components/Receptionist/LatestPatient'
import pdfview from '@/components/Receptionist/pdfview'

import PatientListLab from '@/components/Lab/PatientList'

import Patient from '@/components/Receptionist/Patient'

//patient
import Login from '@/components/Patient/Login'
import PatientReport from '@/components/Patient/PatientReport'


Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/Services',
      name: 'Services',
      component: Services
    },
    {
      path: '/profile',
      name: 'profile',
      component: profile
    },
    //admin test entry page
    {
      path: '/pdfview/:id',
      name: 'pdfview',
      component: pdfview
    },
    
    {
      path: '/TestEntry',
      name: 'TestEntry',
      component: TestEntry,
    },
    {
      path: '/Test',
      name: 'Test',
      component: Test
    },
    {
      path: '/UserEntry',
      name: 'UserEntry',
      component: UserEntry
    },
    //receptionist patient entry page
    {
      path: '/PatientEntry',
      name: 'PatientEntry',
      component: PatientEntry
    },
    //receptionist patient pdf
    {
      path: '/LatestPatient',
      name: 'LatestPatient',
      component: LatestPatient
    },
    //receptionist patient details page
    {
      path: '/PatientList',
      name: 'PatientList',
      component: PatientList
    },
    //receptioninst payment payment page
    {
      path: '/PatientPayment/:id',
      name: 'PatientPayment',
      component: PatientPayment
    },
    //receptionist will print the recept
    {
      path: '/PrintRecept',
      name: 'PrintRecept',
      component: PrintRecept
    },
    {
      path: '/Patient',
      name: 'Patient',
      component: Patient
    },
    //lab report patient list page
    {
      path: '/PatientListLab',
      name: 'PatientListLab',
      component: PatientListLab
    },
    //lab report each patient details
    {
      path: '/ResultEntry/:id',
      name: 'ResultEntry',
      component: ResultEntry
    },
    //patient login
    {
      path: '/PatientLogin',
      name: 'Login',
      component: Login
    },
    //patient report view page
    {
      path: '/PatientReport',
      name: 'PatientReport',
      component: PatientReport
    },
    //login
    {
      path: '/Login',
      name: 'adminLogin',
      component: adminLogin
    },
    
  ]
})
