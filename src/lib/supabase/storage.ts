import { createAdminClient } from './admin';

export type StorageBucket = 'journal-attachments' | 'attendance-photos' | 'avatars';

/**
 * Uploads base64 or file blob to Supabase Storage and returns the public or URL string.
 */
export async function uploadStorageFile(
  bucket: StorageBucket,
  fileName: string,
  fileContent: string // Base64 data URL or string content
): Promise<string | null> {
  try {
    const supabase = createAdminClient();

    // Check if input is base64 data URL (e.g. data:image/png;base64,...)
    let buffer: Buffer;
    let contentType = 'image/jpeg';

    if (fileContent.startsWith('data:')) {
      const parts = fileContent.split(',');
      const match = fileContent.match(/data:(.*?);base64/);
      if (match) contentType = match[1];
      buffer = Buffer.from(parts[1], 'base64');
    } else {
      buffer = Buffer.from(fileContent);
    }

    const filePath = `${Date.now()}-${fileName}`;

    const { data, error } = await supabase.storage
      .from(bucket)
      .upload(filePath, buffer, {
        contentType,
        upsert: true,
      });

    if (error) {
      console.warn(`Supabase storage upload fallback used for ${bucket}:`, error.message);
      // Fallback: return data URL directly if bucket not created or error
      return fileContent;
    }

    const { data: publicUrlData } = supabase.storage
      .from(bucket)
      .getPublicUrl(data.path);

    return publicUrlData.publicUrl;
  } catch (e: any) {
    console.warn('Storage upload error fallback:', e?.message);
    return fileContent;
  }
}
