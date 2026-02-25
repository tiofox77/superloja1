#!/usr/bin/env python3
"""
Stress test: Baixar TODOS os produtos do site
Simula exactamente o que o OpenClaw faz
"""
import urllib.request
import json
import time
import ssl
import os

BASE_URL = "https://superloja.vip/api/v1"
TOKEN = "Popadic17"
PER_PAGE = 15
DELAY = 2
OUTPUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), "produtos_export.json")

CTX = ssl.create_default_context()
CTX.check_hostname = False
CTX.verify_mode = ssl.CERT_NONE

print(f"\n{'='*55}")
print(f"🔥 DOWNLOAD COMPLETO — TODOS OS PRODUTOS")
print(f"   per_page={PER_PAGE}, delay={DELAY}s")
print(f"{'='*55}\n")

all_products = []
page = 1
last_page = 1
success = 0
fail = 0
times = []
total_start = time.time()

while page <= last_page:
    url = f"{BASE_URL}/products?page={page}&per_page={PER_PAGE}&is_active=true"
    
    try:
        req = urllib.request.Request(url)
        req.add_header('Authorization', f'Bearer {TOKEN}')
        req.add_header('Accept', 'application/json')
        req.add_header('User-Agent', 'StressTest/1.0')
        
        start = time.time()
        with urllib.request.urlopen(req, timeout=15, context=CTX) as resp:
            data = json.loads(resp.read().decode())
            elapsed = round((time.time() - start) * 1000)
            times.append(elapsed)
            
            meta = data.get('meta', {})
            last_page = meta.get('last_page', 1)
            total = meta.get('total', '?')
            products = data.get('data', [])
            all_products.extend(products)
            success += 1
            
            print(f"  [{page:2d}/{last_page}] ✅ HTTP {resp.status} | {elapsed:4d}ms | {len(products):2d} produtos | total: {len(all_products)}/{total}")
    
    except urllib.error.HTTPError as e:
        elapsed = round((time.time() - start) * 1000)
        fail += 1
        print(f"  [{page:2d}/??] ❌ HTTP {e.code} | {elapsed:4d}ms | {e.reason}")
        if e.code == 429:
            print(f"         ⚠️ RATE LIMITED! Parar 30s...")
            time.sleep(30)
            continue
    
    except Exception as e:
        elapsed = round((time.time() - start) * 1000) if 'start' in dir() else 0
        fail += 1
        print(f"  [{page:2d}/??] 💀 FALHA | {elapsed:4d}ms | {type(e).__name__}: {e}")
        if any(w in str(e).lower() for w in ['disconnect', 'reset', 'refused', 'eof']):
            print(f"         🔴 SERVIDOR CAIU? Parar 60s...")
            time.sleep(60)
        break
    
    page += 1
    if page <= last_page:
        time.sleep(DELAY)

total_time = round(time.time() - total_start, 1)
avg_time = round(sum(times) / len(times)) if times else 0
max_time = max(times) if times else 0
min_time = min(times) if times else 0
total_requests = success + fail

# Guardar JSON
if all_products:
    result = {
        "updated": time.strftime("%Y-%m-%dT%H:%M:%SZ", time.gmtime()),
        "total": len(all_products),
        "products": []
    }
    for p in all_products:
        img = p.get('featured_image_url', '') or ''
        result['products'].append({
            "id": p.get('id'),
            "name": p.get('name', ''),
            "description": (p.get('description', '') or '')[:100],
            "price": p.get('price', 0),
            "sale_price": p.get('sale_price'),
            "stock_quantity": p.get('stock_quantity', 0),
            "image": img
        })
    with open(OUTPUT, 'w', encoding='utf-8') as f:
        json.dump(result, f, indent=2, ensure_ascii=False)

print(f"\n{'='*55}")
print(f"📊 RESULTADO")
print(f"{'='*55}")
print(f"  📦 Produtos:  {len(all_products)}")
print(f"  ✅ Sucesso:   {success}/{total_requests} requests")
print(f"  ❌ Falhas:    {fail}/{total_requests}")
print(f"  ⏱️  Total:    {total_time}s")
print(f"  📈 Média:     {avg_time}ms")
print(f"  🔼 Máximo:    {max_time}ms")
print(f"  🔽 Mínimo:    {min_time}ms")
if all_products:
    print(f"  💾 JSON:      {OUTPUT}")
print(f"{'='*55}")

if fail == 0:
    print(f"\n🟢 SERVIDOR ESTÁVEL — {len(all_products)} produtos baixados sem falhas!")
elif fail <= 2:
    print(f"\n🟡 SERVIDOR COM STRESS — {fail} falhas")
else:
    print(f"\n🔴 SERVIDOR INSTÁVEL — {fail} falhas")
