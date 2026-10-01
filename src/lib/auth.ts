import { SignJWT, jwtVerify } from 'jose';
import { cookies } from 'next/headers';
import bcrypt from 'bcryptjs';

const JWT_SECRET = new TextEncoder().encode(
  process.env.JWT_SECRET || 'jurnal-pkl-secret-key-2026-very-secure-jwt-token'
);

export interface JWTPayload {
  id: string;
  email: string;
  name: string;
  role: string;
  avatar?: string | null;
}

export async function hashPassword(password: string): Promise<string> {
  return await bcrypt.hash(password, 10);
}

export async function comparePassword(password: string, hash: string): Promise<boolean> {
  return await bcrypt.compare(password, hash);
}

export async function signToken(payload: JWTPayload): Promise<string> {
  return await new SignJWT({ ...payload })
    .setProtectedHeader({ alg: 'HS256' })
    .setIssuedAt()
    .setExpirationTime('7d')
    .sign(JWT_SECRET);
}

export async function verifyToken(token: string): Promise<JWTPayload | null> {
  try {
    const verified = await jwtVerify(token, JWT_SECRET);
    return verified.payload as unknown as JWTPayload;
  } catch (error) {
    return null;
  }
}

export async function getSessionUser(): Promise<JWTPayload | null> {
  const cookieStore = await cookies();
  const token = cookieStore.get('token')?.value;

  if (!token) return null;

  return await verifyToken(token);
}

export function getRoleDisplayName(role: string): string {
  switch (role) {
    case 'siswa':
      return 'Siswa PKL';
    case 'guru_pembimbing':
      return 'Guru Pembimbing';
    case 'mentor':
      return 'Mentor Industri';
    case 'admin_sekolah':
      return 'Admin Sekolah';
    case 'kepala_sekolah':
      return 'Kepala Sekolah';
    case 'admin_platform':
      return 'Admin Platform';
    default:
      return role;
  }
}
