import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

// STYLES
import './css/font-awesome.min.css';
import './css/common.less';
import './css/site.less';
import './css/checkboxes.css';
import './css/redactor.less';
import './css/profile.less';
import './css/poem.less';
import './css/auth.less';



// SCRIPTS
import './js/editor.js';
import './js/site.js';

// SVG
// requireAll(require.context('./img/', true, /\.svg$/));



// Функция для получения всех файлов
function requireAll(r) {
  r.keys().forEach(r);
}
