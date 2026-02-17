export default async function handler(req, res) {
  // 1. Ambil tag dari URL
  const { tag } = req.query;

  if (!tag) {
    return res.status(400).json({ error: "Tag tidak ditemukan" });
  }

  // 2. Token diambil dari "Brankas" Vercel (Environment Variable)
  // Biar aman dan tidak terekspos di public
  const token = process.env.COC_TOKEN;

  // 3. Panggil API CoC
  try {
    const response = await fetch(`https://api.clashofclans.com/v1/players/%23${tag}`, {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
      },
    });

    // 4. Cek jika token ditolak karena masalah IP
    if (response.status === 403) {
      return res.status(403).json({ 
        error: "Access Denied. IP Vercel berubah atau Token salah.",
        detail: "CoC API butuh whitelist IP statis." 
      });
    }

    const data = await response.json();
    
    // 5. Kirim data balik ke frontend
    res.status(200).json(data);
    
  } catch (error) {
    res.status(500).json({ error: "Gagal mengambil data server" });
  }
}