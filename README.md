## Overview
EC2-Instance-Manager is a web-based tool for managing Amazon EC2 instances. It provides a user-friendly interface to start, stop, force stop, and modify instance types of your EC2 instances across different AWS regions. The tool also includes security group management for controlling RDP/SSH access.

## Features
- Basic instance operations (start/stop/force stop)
- Instance type modification with automatic workflow
- Security group management for RDP/SSH access
- Real-time instance status monitoring
- Responsive design with visual status indicators
- Support for both Windows and Linux instances
- Auto-refresh every 15 seconds

## Requirements
- PHP 7.4 or higher
- AWS SDK for PHP
- Web server (Apache/Nginx)
- HTTPS enabled (recommended)

## Installation
1. Clone the repository:
   ```
   git clone https://github.com/daishir0/EC2-Instance-Manager.git
   ```
2. Install AWS SDK for PHP:
   ```
   composer require aws/aws-sdk-php
   ```
3. Edit `index.php` and configure:
   - AWS credentials (aws_access_key_id, aws_secret_access_key)
   - Basic authentication credentials (username, password)
   - Instance information (id, name, region, instance types)
   - RDP port (if needed)

## Usage
1. Access the web interface through your browser
2. Enter the Basic authentication credentials
3. Manage your instances:
   - View instance status (color-coded):
     - Green: Running (standard type)
     - Dark Green: Running (enhanced type)
     - Red: Stopped
   - Use buttons to control instances:
     - Start
     - Stop
     - Force Stop
     - Modify Type (automatic stop → change → start)
   - Control RDP/SSH access:
     - Connectable (Green): Port closed
     - Unconnectable (Red): Port open

## Instance Type Modification
1. Select desired type from dropdown
2. Click "Modify Type"
3. The system automatically:
   - Stops the instance (if running)
   - Changes the instance type
   - Starts the instance again
4. Progress is displayed in real-time

## Security Considerations
- Store AWS credentials securely
- Change default Basic authentication credentials
- Deploy behind HTTPS
- Use specific IP ranges in security groups when possible
- Regular monitoring of access logs

## Notes
- Instance states refresh automatically every 15 seconds
- Security group changes are also monitored and updated
- The tool manages both Windows (RDP) and Linux (SSH) instances
- Instance types are defined per-instance in the configuration

## License
This project is licensed under the MIT License - see the LICENSE file for details.

---

# EC2インスタンスマネージャー

## 概要
EC2インスタンスマネージャーは、Amazon EC2インスタンスを管理するためのWebベースの単一ファイルツールです。異なるAWSリージョンにまたがるEC2インスタンスの起動、停止、強制停止、およびインスタンスタイプの変更が可能です。また、RDP/SSHアクセスのためのセキュリティグループ管理機能も備えています。

## 機能
- 基本的なインスタンス操作（起動/停止/強制停止）
- インスタンスタイプの自動変更ワークフロー
- RDP/SSHアクセスのセキュリティグループ管理
- リアルタイムのステータス監視
- レスポンシブデザインと視覚的なステータス表示
- WindowsとLinuxインスタンスの対応
- 15秒ごとの自動更新

## 必要条件
- PHP 7.4以上
- AWS SDK for PHP
- Webサーバー（Apache/Nginx）
- HTTPS有効（推奨）

## インストール方法
1. リポジトリのクローン：
   ```
   git clone https://github.com/daishir0/EC2-Instance-Manager.git
   ```
2. AWS SDKのインストール：
   ```
   composer require aws/aws-sdk-php
   ```
3. `index.php`の設定：
   - AWS認証情報（aws_access_key_id、aws_secret_access_key）
   - Basic認証情報（ユーザー名、パスワード）
   - インスタンス情報（ID、名前、リージョン、インスタンスタイプ）
   - RDPポート（必要な場合）

## 使用方法
1. ブラウザからWebインターフェースにアクセス
2. Basic認証情報を入力
3. インスタンスの管理：
   - ステータス表示（色分け）：
     - 緑：実行中（標準タイプ）
     - 濃い緑：実行中（拡張タイプ）
     - 赤：停止中
   - 操作ボタン：
     - 起動
     - 停止
     - 強制停止
     - タイプ変更（自動的に停止→変更→起動）
   - RDP/SSHアクセス制御：
     - Connectable（緑）：ポート閉鎖
     - Unconnectable（赤）：ポート開放

## セキュリティ上の注意
- AWS認証情報の安全な管理
- Basic認証のデフォルト認証情報の変更
- HTTPSでの運用
- 可能な限り特定のIPレンジを使用
- アクセスログの定期的な確認

## 注意点
- インスタンスの状態は15秒ごとに自動更新
- セキュリティグループの変更も監視・更新
- WindowsとLinuxの両インスタンスに対応
- インスタンスタイプは設定で個別に定義

## ライセンス
このプロジェクトはMITライセンスの下で提供されています。詳細はLICENSEファイルを参照してください。
