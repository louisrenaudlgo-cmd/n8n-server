require('dotenv').config();
const express = require('express');
const app = express();
app.use(express.json());

const TOKEN = process.env.AIRTABLE_TOKEN;
const BASE = process.env.AIRTABLE_BASE || 'appKcSkKFRoIQ6tGG';
const TABLE = 'tbl3G3iNx1H15D7Ol';
const HEADERS = { 'Authorization': 'Bearer ' + TOKEN, 'Content-Type': 'application/json' };

async function airtable(path, options) {
  const fetch = (await import('node-fetch')).default;
  let records = [], offset = null;
  do {
    const sep = path.includes('?') ? '&' : '?';
    const url = 'https://api.airtable.com/v0/' + BASE + '/' + TABLE + path + (offset ? sep + 'offset=' + offset : '');
    const r = await fetch(url, { headers: HEADERS, ...options });
    const data = await r.json();
    records = records.concat(data.records || []);
    offset = data.offset || null;
  } while (offset);
  return { records };
}

app.get('/api/counts', async (req, res) => {
  try {
    const [d1, d2] = await Promise.all([
      airtable('?filterByFormula=AND(NOT({a_signaler}),NOT({signale}))'),
      airtable('?filterByFormula={signale}=1')
    ]);
    res.json({ aValider: (d1.records||[]).length, signales: (d2.records||[]).length });
  } catch(e) { res.status(500).json({ error: e.message }); }
});

app.get('/api/a-valider', async (req, res) => {
  try {
    const d = await airtable('?filterByFormula=AND(NOT({a_signaler}),NOT({signale}))&sort[0][field]=score_risque&sort[0][direction]=desc');
    res.json((d.records||[]).map(r => ({ id: r.id, ...r.fields })));
  } catch(e) { res.status(500).json({ error: e.message }); }
});

app.get('/api/signales', async (req, res) => {
  try {
    const d = await airtable('?filterByFormula={signale}=1&sort[0][field]=date_signalement_arcom&sort[0][direction]=desc');
    res.json((d.records||[]).map(r => ({ id: r.id, ...r.fields })));
  } catch(e) { res.status(500).json({ error: e.message }); }
});

app.post('/api/signaler/:id', async (req, res) => {
  try {
    await airtable('/' + req.params.id, { method: 'PATCH', body: JSON.stringify({ fields: { a_signaler: true } }) });
    res.json({ success: true });
  } catch(e) { res.status(500).json({ error: e.message }); }
});

app.post('/api/ignorer/:id', async (req, res) => {
  try {
    await airtable('/' + req.params.id, { method: 'PATCH', body: JSON.stringify({ fields: { signale: true } }) });
    res.json({ success: true });
  } catch(e) { res.status(500).json({ error: e.message }); }
});

app.get('/', (req, res) => {
  res.send(`<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ARCOM Validation</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:-apple-system,BlinkMacSystemFont,sans-serif;background:#f7f7f7;color:#222}
    #dashboard{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;gap:20px;padding:24px}
    #dashboard h1{font-size:22px;color:#555;font-weight:400;margin-bottom:12px}
    .dash-btn{width:280px;padding:24px;border-radius:16px;border:none;cursor:pointer;font-size:16px;font-weight:600;box-shadow:0 4px 12px rgba(0,0,0,0.1);transition:transform 0.1s}
    .dash-btn:hover{transform:translateY(-2px)}
    .dash-btn .number{font-size:48px;font-weight:700;display:block;margin-bottom:6px}
    .btn-valider{background:#1a1a2e;color:white}
    .btn-valider .number{color:#ff6b6b}
    .btn-signales{background:white;color:#333;border:2px solid #eee}
    .btn-signales .number{color:#51cf66}
    #vue-infraction,#vue-signales{display:none;min-height:100vh;flex-direction:column}
    .top-bar{background:#1a1a2e;color:white;padding:16px 20px;display:flex;align-items:center;gap:12px}
    .back-btn{background:none;border:none;color:white;font-size:20px;cursor:pointer}
    .top-bar h2{font-size:16px;font-weight:500;flex:1}
    .counter{font-size:13px;opacity:0.7}
    .inf-body{flex:1;padding:20px;max-width:700px;margin:0 auto;width:100%;overflow-y:auto}
    .score{font-size:36px;font-weight:700;margin-bottom:4px}
    .emission{font-size:14px;color:#888;margin-bottom:8px}
    .locuteur{font-size:16px;font-weight:700;color:#1a1a2e;margin-bottom:4px}
    .meta{font-size:13px;color:#888;margin-bottom:12px}
    .tag{display:inline-block;background:#f0f0f0;border-radius:4px;padding:2px 8px;font-size:12px;margin-right:4px;margin-bottom:12px}
    .label{font-size:11px;font-weight:700;text-transform:uppercase;color:#aaa;margin-bottom:6px;letter-spacing:0.5px}
    .verbatim{background:#fff8e1;border-left:3px solid #ffc107;padding:12px;border-radius:6px;font-size:14px;font-style:italic;margin-bottom:16px;line-height:1.6;max-height:150px;overflow-y:auto}
    .analyse{background:#f8f8f8;padding:12px;border-radius:6px;font-size:14px;margin-bottom:24px;line-height:1.6;max-height:150px;overflow-y:auto}
    .actions{display:flex;gap:12px;padding:16px 20px;background:white;border-top:1px solid #eee;position:sticky;bottom:0}
    .actions button{flex:1;padding:16px;border:none;border-radius:12px;font-size:16px;font-weight:700;cursor:pointer}
    .btn-ok{background:#1a1a2e;color:white}
    .btn-ko{background:#f0f0f0;color:#666}
    .sig-list{padding:16px}
    .sig-row{background:white;border-radius:10px;padding:14px 16px;margin-bottom:10px;border-left:4px solid #51cf66}
    .sig-title{font-size:14px;font-weight:600;margin-bottom:4px}
    .sig-locuteur{font-size:13px;font-weight:600;color:#1a1a2e;margin-bottom:4px}
    .sig-meta{font-size:12px;color:#888;display:flex;gap:12px;flex-wrap:wrap;margin-bottom:8px}
    .sig-analyse{font-size:12px;color:#555;background:#f8f8f8;padding:8px 10px;border-radius:6px;margin-bottom:6px;line-height:1.5}
    .sig-num{font-size:11px;color:#aaa;font-family:monospace}
    .empty{text-align:center;padding:60px 20px;color:#aaa;font-size:16px}
    .spinner{text-align:center;padding:40px;color:#aaa}
  </style>
</head>
<body>
<div id="dashboard">
  <h1>🎯 ARCOM Validation</h1>
  <button class="dash-btn btn-valider" onclick="ouvrirValidation()">
    <span class="number" id="nb-valider">...</span>infractions à valider
  </button>
  <button class="dash-btn btn-signales" onclick="ouvrirSignales()">
    <span class="number" id="nb-signales">...</span>signalements envoyés
  </button>
</div>

<div id="vue-infraction">
  <div class="top-bar">
    <button class="back-btn" onclick="retour()">←</button>
    <h2>Validation infractions</h2>
    <span class="counter" id="counter"></span>
  </div>
  <div class="inf-body" id="inf-body"><div class="spinner">Chargement...</div></div>
  <div class="actions">
    <button class="btn-ko" onclick="ignorer()">❌ Ignorer</button>
    <button class="btn-ok" onclick="signaler()">✅ Signaler</button>
  </div>
</div>

<div id="vue-signales">
  <div class="top-bar">
    <button class="back-btn" onclick="retour()">←</button>
    <h2>Signalements envoyés</h2>
  </div>
  <div class="sig-list" id="sig-list"><div class="spinner">Chargement...</div></div>
</div>

<script>
let data = [], idx = 0;

async function loadCounts() {
  const r = await fetch('/api/counts');
  const d = await r.json();
  document.getElementById('nb-valider').textContent = d.aValider;
  document.getElementById('nb-signales').textContent = d.signales;
}

async function ouvrirValidation() {
  show('vue-infraction');
  document.getElementById('inf-body').innerHTML = '<div class="spinner">Chargement...</div>';
  const r = await fetch('/api/a-valider');
  data = await r.json();
  idx = 0;
  afficher();
}

function afficher() {
  if (!data.length) {
    document.getElementById('inf-body').innerHTML = '<div class="empty">✅ Toutes les infractions ont été traitées !</div>';
    document.getElementById('counter').textContent = '';
    return;
  }
  const d = data[idx];
  document.getElementById('counter').textContent = (idx+1) + ' / ' + data.length;
  const sc = d.score_risque >= 70 ? '#ff6b6b' : d.score_risque >= 40 ? '#ff9900' : '#51cf66';
  document.getElementById('inf-body').innerHTML =
    '<div class="score" style="color:'+sc+'">'+(d.score_risque||'?')+'</div>'+
    '<div class="emission">'+(d.titre_emission||'')+' — '+(d.date_emission||'')+'</div>'+
    '<div class="locuteur">🎙️ '+(d.locuteur||'')+'</div>'+
    '<div class="meta">⏱️ '+(d.timestamp_debut||'')+' → '+(d.timestamp_citation||'')+'</div>'+
    '<div style="margin-bottom:12px">'+
      '<span class="tag">'+(d.type_infraction||'')+'</span>'+
      '<span class="tag">'+(d.article_applicable||'')+'</span>'+
      '<span class="tag">'+(d.sanction_reference||'')+'</span>'+
    '</div>'+
    '<div class="label">Verbatim</div>'+
    '<div class="verbatim">'+(d.citation||'')+'</div>'+
    '<div class="label">Analyse</div>'+
    '<div class="analyse">'+(d.analyse||'')+'</div>';
}

async function signaler() {
  await fetch('/api/signaler/'+data[idx].id, {method:'POST'});
  data.splice(idx,1);
  if(idx>=data.length) idx=Math.max(0,data.length-1);
  afficher(); loadCounts();
}

async function ignorer() {
  await fetch('/api/ignorer/'+data[idx].id, {method:'POST'});
  data.splice(idx,1);
  if(idx>=data.length) idx=Math.max(0,data.length-1);
  afficher(); loadCounts();
}

async function ouvrirSignales() {
  show('vue-signales');
  document.getElementById('sig-list').innerHTML = '<div class="spinner">Chargement...</div>';
  const r = await fetch('/api/signales');
  const d = await r.json();
  if(!d.length) { document.getElementById('sig-list').innerHTML='<div class="empty">Aucun signalement</div>'; return; }
  document.getElementById('sig-list').innerHTML = d.map(d =>
    '<div class="sig-row">'+
      '<div class="sig-title">'+(d.titre_emission||'')+'</div>'+
      '<div class="sig-locuteur">🎙️ '+(d.locuteur||'')+'</div>'+
      '<div class="sig-meta">'+
        '<span>📅 '+(d.date_signalement_arcom||d.date_emission||'')+'</span>'+
        '<span>⏱️ '+(d.timestamp_debut||'')+'</span>'+
        '<span style="color:'+(d.score_risque>=70?'#ff6b6b':'#ff9900')+'">Score: '+(d.score_risque||'')+'</span>'+
      '</div>'+
      '<div class="sig-analyse">'+(d.analyse||'').substring(0,250)+(d.analyse&&d.analyse.length>250?'...':'')+'</div>'+
      '<div class="sig-num">'+(d.numero_signalement||'')+'</div>'+
    '</div>'
  ).join('');
}

function show(id) {
  ['dashboard','vue-infraction','vue-signales'].forEach(i => {
    document.getElementById(i).style.display = i===id ? 'flex' : 'none';
    if(i===id) document.getElementById(i).style.flexDirection = 'column';
  });
}

function retour() { show('dashboard'); loadCounts(); }

loadCounts();
</script>
</body>
</html>`);
});

app.listen(3001, () => console.log('WebApp port 3001'));

const AT = process.env.AIRTABLE_TOKEN;
const AB = process.env.AIRTABLE_BASE || 'appKcSkKFRoIQ6tGG';
async function atFetch(tbl, fields) {
  const {default:fetch} = await import('node-fetch');
  let rec=[], off=null;
  const f = fields.map(x=>'fields[]='+encodeURIComponent(x)).join('&');
  do {
    const url='https://api.airtable.com/v0/'+AB+'/'+tbl+'?'+f+'&pageSize=100'+(off?'&offset='+off:'');
    const r = await fetch(url,{headers:{Authorization:'Bearer '+AT}});
    const d = await r.json();
    if(d.error) throw new Error(d.error.message);
    rec = rec.concat(d.records);
    off = d.offset||null;
  } while(off);
  return rec;
}
let _c=null, _t=0;
app.get('/api/stats', async(req,res)=>{
  res.setHeader('Access-Control-Allow-Origin','*');
  res.setHeader('Content-Type','application/json');
  try {
    if(_c && Date.now()-_t<300000) return res.json(_c);
    const [sig,vid] = await Promise.all([
      atFetch('tbl3G3iNx1H15D7Ol',['Chaine','mail_valide']),
      atFetch('tbl0f6aVzBpUpbo7P',['duree_minutes'])
    ]);
    const ch=new Set();
    sig.forEach(r=>{const v=r.fields['Chaine'];if(v)Array.isArray(v)?v.forEach(c=>ch.add(c)):ch.add(v);});
    const nv=sig.filter(r=>r.fields['mail_valide']===true).length;
    const tm=vid.reduce((s,r)=>s+(!isNaN(r.fields["duree_minutes"])?parseFloat(r.fields['duree_minutes']):0),0);
    _c={signalements:sig.length,chaines:ch.size,heures:Math.round(tm/60),taux:sig.length>0?Math.round((nv/sig.length)*100):0};
    _t=Date.now();
    res.json(_c);
  } catch(e){res.status(500).json({error:e.message});}
});
