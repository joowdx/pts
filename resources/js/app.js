/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap'


/**
 * Import adminlte
 */
import 'admin-lte'

import 'bootstrap-select'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new vue({el: '#vue',})



window.uppercasefirst = e => e.trim().charAt(0).toUpperCase() + e.slice(1)
window.titlecase = e => e.trim().split(/\s+/igm).map(uppercasefirst).join(' ')

$('.custom-file-input').on('change',function(e) {
  $(this).next('.custom-file-label').html(e.target.files[0].name).css('color', '#495057')
})
